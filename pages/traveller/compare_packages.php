<?php
    //u24611400 Anke de Frey
    //Package Comparison Page - compare two holiday packages side-by-side.
    //All package data comes from real database queries in compare_packages_queries.php.

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/compare_packages_queries.php';

    //session.php
    redirectIfNotTraveller();

    //session.php
    $userID = getCurrentUserID();

    //auth.php
    $userResult = getTravellerByUserID($userID);

    //validation.php
    if($userResult['success']){
        $userName = sanitise($userResult['user']['Name']);
    }else{
        $userName = 'Traveller';
    }

    //compare_packages_queries.php - all packages available for comparison (real DB data)
    $packages = getComparisonPackages($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare Packages - Tripistry</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/compare_packages.css">
</head>

<body>

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo">Tripistry</div>

        <ul>
            <li><a href="traveller_dashboard.php">Home</a></li>
            <li><a href="destinations.php">Destinations</a></li>
            <li><a href="flights.php">Flights</a></li>
            <li><a href="accommodations.php">Accommodations</a></li>
            <li><a href="attractions.php">Attractions</a></li>
            <li><a href="restaurants.php">Restaurants</a></li>
            <li><a href="compare_packages.php" class="active-link">Compare Packages</a></li>
            <li><a href="bookings.php">My Bookings</a></li>
            <li><a href="reviews.php">Reviews</a></li>
        </ul>

        <a href="../logout.php" class="sidebar-logout">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOP BAR -->
        <div class="topbar">
            <div class="profile">
                Welcome, <?php echo htmlspecialchars($userName); ?>
            </div>
        </div>

        <div class="compare-wrap">

            <!-- HERO / CALL TO ACTION -->
            <section class="compare-hero">
                <h1>Compare Your Trips Side by Side</h1>
            </section>

            <?php if(count($packages) < 2): ?>

                <section class="compare-panel">
                    <h2 class="compare-section-title">Choose Two Packages</h2>
                    <p>There need to be at least two packages in the database to compare. Add more packages and check back.</p>
                </section>

            <?php else: ?>

                <!-- PACKAGE SELECTORS -->
                <section class="compare-panel" id="compare-section">
                    <h2 class="compare-section-title">Choose Two Packages</h2>

                    <div class="compare-selectors">
                        <div class="selector slot-a">
                            <label for="package1-select">Select Package 1</label>
                            <select id="package1-select" onchange="renderComparison()">
                                <?php foreach($packages as $index => $package): ?>
                                    <option value="<?php echo (int)$package['id']; ?>" <?php if($index === 0){ echo 'selected'; } ?>>
                                        <?php echo htmlspecialchars($package['name'] . ' - ' . $package['location']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="selector slot-b">
                            <label for="package2-select">Select Package 2</label>
                            <select id="package2-select" onchange="renderComparison()">
                                <?php foreach($packages as $index => $package): ?>
                                    <option value="<?php echo (int)$package['id']; ?>" <?php if($index === 1){ echo 'selected'; } ?>>
                                        <?php echo htmlspecialchars($package['name'] . ' - ' . $package['location']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div id="compare-notice"></div>
                </section>

                <!-- SIDE-BY-SIDE COMPARISON CARDS -->
                <section>
                    <div class="compare-cards" id="compare-cards"></div>
                </section>

                <!-- COST BREAKDOWN -->
                <section class="compare-panel">
                    <h2 class="compare-section-title">Cost Breakdown</h2>
                    <div id="cost-breakdown"></div>
                </section>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php if(count($packages) >= 2): ?>
<script>
/*  Package comparison logic.
    Every package below is real data from the database (see
    compare_packages_queries.php). The cards and cost breakdown are
    built in the browser so the page updates instantly with no reload. */
    (function(){
        'use strict';

        var PACKAGES = <?php echo json_encode(array_values($packages), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;

        /* ---- small helpers ---- */
        function fmtR(n){
            return 'R' + Math.round(n).toLocaleString('en-ZA');
        }

        function escapeHtml(s){
            return String(s).replace(/[&<>"']/g, function(c){
                return { '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;' }[c];
            });
        }

        function stars(n){
            n = Math.max(0, Math.min(5, Math.round(n)));
            return '★'.repeat(n) + '☆'.repeat(5 - n);
        }

        function pkgById(id){
            for(var i = 0; i < PACKAGES.length; i++){
                if(String(PACKAGES[i].id) === String(id)){
                    return PACKAGES[i];
                }
            }
            return null;
        }

        function specRow(label, valHtml){
            return '<div class="spec-row">' +
                    '<span class="spec-label">' + escapeHtml(label) + '</span>' +
                    '<span class="spec-val">' + valHtml + '</span>' +
                    '</div>';
        }

        /* ---- builders for the real included items ---- */
        function flightsHtml(flights){
            if(!flights.length){
                return '<span class="muted">No flights included</span>';
            }
            return flights.map(function(f){
                return escapeHtml(f.airline) +
                    '<br><span class="muted">' + escapeHtml(f.route) +
                    ' &middot; ' + fmtR(f.price) + '</span>';
            }).join('<br>');
        }

        function accommodationHtml(accommodations){
            if(!accommodations.length){
                return '<span class="muted">No accommodation included</span>';
            }
            return accommodations.map(function(a){
                return escapeHtml(a.name) +
                    '<br><span class="muted">' + escapeHtml(a.type) +
                    ' &middot; ' + fmtR(a.pricePN) + ' per night</span>';
            }).join('<br>');
        }

        function pillsHtml(items, emptyText){
            if(!items.length){
                return '<span class="muted">' + escapeHtml(emptyText) + '</span>';
            }
            return '<div class="activity-pills">' + items.map(function(i){
                return '<span class="activity-pill">' + escapeHtml(i) + '</span>';
            }).join('') + '</div>';
        }

        function cardHtml(p, slot){
            var imgInner = '';
            if(p.image){
                imgInner = '<img src="' + escapeHtml(p.image) + '" alt="' + escapeHtml(p.name) + '" onerror="this.style.display=\'none\'">';
            }

            var restaurantNames = p.restaurants.map(function(r){
                if(r.cuisine){
                    return r.name + ' (' + r.cuisine + ')';
                }
                return r.name;
            });

            var spotsText = p.spotsLeft + ' of ' + p.capacity + ' spots left';
            if(p.spotsLeft <= 0){
                spotsText = 'Fully booked';
            }

            return '' +
            '<div class="compare-card card-' + slot + '">' +
                '<div class="compare-card-img ph-ocean">' +
                    imgInner +
                    '<span>' + escapeHtml(p.location) + '</span>' +
                '</div>' +
                '<div class="compare-card-body">' +
                    '<h3 class="compare-card-title">' + escapeHtml(p.name) + '</h3>' +
                    '<div class="compare-card-loc">' + escapeHtml(p.location) + '</div>' +
                    '<div class="compare-card-price">' + fmtR(p.price) +
                        ' <span>total per person</span></div>' +
                    '<div class="spec">' +
                        specRow('Agency', escapeHtml(p.agency)) +
                        specRow('Duration', p.duration + ' days') +
                        specRow('Price per day', fmtR(p.price / p.duration)) +
                        specRow('Availability', escapeHtml(spotsText)) +
                        specRow('Traveller rating',
                            '<span class="spec-stars">' + stars(p.rating) + '</span> ' +
                            '<span class="spec-rating-num">' + p.rating.toFixed(1) + '</span> ' +
                            '<span class="muted">(' + p.reviews + ' reviews)</span>') +
                        specRow('Flights', flightsHtml(p.flights)) +
                        specRow('Accommodation', accommodationHtml(p.accommodations)) +
                        specRow('Attractions', pillsHtml(p.attractions, 'None included')) +
                        specRow('Restaurants', pillsHtml(restaurantNames, 'None included')) +
                    '</div>' +
                    '<a class="compare-card-link card-link-' + slot + '" ' +
                    'href="package_details.php?id=' + encodeURIComponent(p.id) + '">' +
                    'View package page</a>' +
                '</div>' +
            '</div>';
        }

        function renderCards(p1, p2){
            document.getElementById('compare-cards').innerHTML =
                cardHtml(p1, 'a') + cardHtml(p2, 'b');
        }

        /* one money row for the cost table; the cheaper side is highlighted */
        function costRow(label, v1, v2, opts){
            opts = opts || {};

            var cls1 = '';
            var cls2 = '';
            if(v1 < v2){
                cls1 = ' class="cheaper"';
            }
            if(v2 < v1){
                cls2 = ' class="cheaper"';
            }

            var display1 = fmtR(v1);
            var display2 = fmtR(v2);
            if(opts.note1){
                display1 = opts.note1;
            }
            if(opts.note2){
                display2 = opts.note2;
            }

            var rowClass = '';
            if(opts.rowClass){
                rowClass = ' class="' + opts.rowClass + '"';
            }

            return '<tr' + rowClass + '>' +
                '<td><span class="cost-cat">' + escapeHtml(label) + '</span></td>' +
                '<td' + cls1 + '>' + display1 + '</td>' +
                '<td' + cls2 + '>' + display2 + '</td>' +
            '</tr>';
        }

        function renderCosts(p1, p2){
            //per-day price and the whole-stay accommodation cost, all from real prices
            var perDay1 = p1.price / p1.duration;
            var perDay2 = p2.price / p2.duration;
            var accomTotal1 = p1.accommodationPerNight * p1.duration;
            var accomTotal2 = p2.accommodationPerNight * p2.duration;

            var body =
                costRow('Flights included (total)', p1.flightsTotal, p2.flightsTotal) +
                costRow('Accommodation per night', p1.accommodationPerNight, p2.accommodationPerNight) +
                costRow('Accommodation for the whole stay', accomTotal1, accomTotal2, {
                    note1: fmtR(p1.accommodationPerNight) + ' &times; ' + p1.duration + ' nights = ' + fmtR(accomTotal1),
                    note2: fmtR(p2.accommodationPerNight) + ' &times; ' + p2.duration + ' nights = ' + fmtR(accomTotal2)
                }) +
                costRow('Booking fee', p1.fee, p2.fee) +
                costRow('Price per day', perDay1, perDay2) +
                costRow('Package price (per person)', p1.price, p2.price, { rowClass: 'cost-total-row' });

            var table =
                '<table class="cost-table">' +
                    '<thead><tr>' +
                        '<th>Cost</th>' +
                        '<th class="col-a">' + escapeHtml(p1.name) + '</th>' +
                        '<th class="col-b">' + escapeHtml(p2.name) + '</th>' +
                    '</tr></thead>' +
                    '<tbody>' + body + '</tbody>' +
                '</table>';

            document.getElementById('cost-breakdown').innerHTML = table;
        }

        function renderComparison(){
            var sel1 = document.getElementById('package1-select');
            var sel2 = document.getElementById('package2-select');

            /* stop both dropdowns landing on the same package */
            Array.prototype.forEach.call(sel1.options, function(o){
                o.disabled = (o.value === sel2.value);
            });
            Array.prototype.forEach.call(sel2.options, function(o){
                o.disabled = (o.value === sel1.value);
            });

            var p1 = pkgById(sel1.value);
            var p2 = pkgById(sel2.value);

            var notice = document.getElementById('compare-notice');
            if(!p1 || !p2){
                return;
            }

            if(p1.id === p2.id){
                notice.innerHTML = '<div class="compare-notice">' +
                    'Please choose two different packages to compare.</div>';
            } else {
                notice.innerHTML = '';
            }

            renderCards(p1, p2);
            renderCosts(p1, p2);
        }

        /* expose for the inline onchange handlers */
        window.renderComparison = renderComparison;

        /* first render */
        document.addEventListener('DOMContentLoaded', renderComparison);
    })();
</script>
<?php endif; ?>

</body>
</html>
                                                                                                                                                                                                                             