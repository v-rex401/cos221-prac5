<?php
    //u24611400 Anke de Frey
    //Package Comparison Page - compare two holiday packages side-by-side.
    //NOTE: package data currently comes from MOCK data in compare_packages_queries.php. Swap that for real DB queries

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

    //compare_packages_queries.php - all packages available for comparison
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
            <li><a href="packages.php">Packages</a></li>
            <li><a href="compare_packages.php">Compare Packages</a></li>
            <li><a href="bookings.php">Bookings</a></li>
            <li><a href="reviews.php">Reviews</a></li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOP BAR -->
        <div class="topbar">
            <div class="profile">
                Welcome, <?php echo htmlspecialchars($userName); ?>
                <a href="../logout.php" class="logout-link">Logout</a>
            </div>
        </div>

        <div class="compare-wrap">

            <!-- HERO / CALL TO ACTION -->
            <section class="compare-hero">
                <h1>Compare Your Trips Side by Side</h1>
                
            </section>

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
                <h2 class="compare-section-title">Cost Breakdown per day per person</h2>
                <div id="cost-breakdown"></div>
            </section>

        </div>

    </div>

</div>

<script>
/*  Package comparison logic.
    All package data is supplied by PHP below (currently mock data).
    The comparison cards and cost breakdown are computed here in the
    browser so the page updates instantly with no reload. */
    (function(){
        'use strict';

        var PACKAGES = <?php echo json_encode(array_values($packages)); ?>;


        var COST_CATS = [
            { key:'accommodation', label:'Accommodation' },
            { key:'activities', label:'Activities' },
            { key:'meals', label:'Meals' },
            { key:'transfers', label:'Transfers' },
            { key:'taxes', label:'Taxes & fees' }
        ];

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
                if(String(PACKAGES[i].id) === String(id)) return PACKAGES[i];
            }
            return null;
        }

        function specRow(label, valHtml){
            return '<div class="spec-row">' +
                    '<span class="spec-label">' + escapeHtml(label) + '</span>' +
                    '<span class="spec-val">' + valHtml + '</span>' +
                    '</div>';
        }

        function cardHtml(p, slot){
            var phClass = ' ph-' + escapeHtml(p.theme || 'ocean');
            var imgInner = '';
            if(p.image){
                imgInner = '<img src="' + escapeHtml(p.image) + '" alt="' + escapeHtml(p.name) + '" onerror="this.style.display=\'none\'">';
            }

            var activityPills = p.activities.map(function(a){
                return '<span class="activity-pill">' + escapeHtml(a) + '</span>';
            }).join('');

            return '' +
            '<div class="compare-card card-' + slot + '">' +
                '<div class="compare-card-img' + phClass + '">' +
                    imgInner +
                    '<span>' + escapeHtml(p.location) + '</span>' +
                '</div>' +
                '<div class="compare-card-body">' +
                    '<h3 class="compare-card-title">' + escapeHtml(p.name) + '</h3>' +
                    '<div class="compare-card-loc">' + escapeHtml(p.location) + '</div>' +
                    '<div class="compare-card-price">' + fmtR(p.price) +
                        ' <span>total per person</span></div>' +
                    '<div class="spec">' +
                        specRow('Duration', p.duration + ' days') +
                        specRow('Flights',
                            escapeHtml(p.flight.airline) +
                            '<br><span class="muted">' + escapeHtml(p.flight.route) + '</span>' +
                            '<br><span class="muted">' + escapeHtml(p.flight['class']) +
                            ' &middot; ' + escapeHtml(p.flight.stops) + '</span>') +
                        specRow('Accommodation',
                            escapeHtml(p.accommodation.name) +
                            '<br><span class="muted">' + escapeHtml(p.accommodation.type) +
                            ' &middot; ' + p.accommodation.nights + ' nights</span>') +
                        specRow('Hotel rating',
                            '<span class="spec-stars">' + stars(p.accommodation.stars) + '</span> ' +
                            '<span class="muted">' + p.accommodation.stars + '-star</span>') +
                        specRow('Meals', escapeHtml(p.meals)) +
                        specRow('Activities', '<div class="activity-pills">' + activityPills + '</div>') +
                        specRow('Transfers', escapeHtml(p.transfers)) +
                        specRow('Traveller rating',
                            '<span class="spec-stars">' + stars(p.rating) + '</span> ' +
                            '<span class="spec-rating-num">' + p.rating.toFixed(1) + '</span> ' +
                            '<span class="muted">(' + p.reviews + ' reviews)</span>') +
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

        function renderCosts(p1, p2){
            //per-day, per-person rows for everything except flights
            var rows = COST_CATS.map(function(c){
                //divide each category cost by the trip length to get
                //the per-day, per-person figure
                var v1 = p1.costs[c.key] / p1.duration;
                var v2 = p2.costs[c.key] / p2.duration;
                var cls1 = '';
                if(v1 < v2){
                    cls1 = ' class="cheaper"';
                }
                var cls2 = '';
                if(v2 < v1){
                    cls2 = ' class="cheaper"';
                }
                return '<tr>' +
                    '<td><span class="cost-cat">' + c.label + '</span></td>' +
                    '<td' + cls1 + '>' + fmtR(v1) + '</td>' +
                    '<td' + cls2 + '>' + fmtR(v2) + '</td>' +
                '</tr>';
            }).join('');

            //per-day total - excludes flights (a flight is a one-off cost, not a daily one)
            var dayTotal1 = (p1.costs.total - p1.costs.flights) / p1.duration;
            var dayTotal2 = (p2.costs.total - p2.costs.flights) / p2.duration;
            var dcls1 = '';
            if(dayTotal1 < dayTotal2){
                dcls1 = ' class="cheaper"';
            }
            var dcls2 = '';
            if(dayTotal2 < dayTotal1){
                dcls2 = ' class="cheaper"';
            }

            //flights - shown as a single per-person price, not divided by days
            var flights1 = p1.costs.flights;
            var flights2 = p2.costs.flights;
            var fcls1 = '';
            if(flights1 < flights2){
                fcls1 = ' class="cheaper"';
            }
            var fcls2 = '';
            if(flights2 < flights1){
                fcls2 = ' class="cheaper"';
            }

            //real total - the full per-person trip cost, flights included
            var total1 = p1.costs.total;
            var total2 = p2.costs.total;
            var tcls1 = '';
            if(total1 < total2){
                tcls1 = ' class="cheaper"';
            }
            var tcls2 = '';
            if(total2 < total1){
                tcls2 = ' class="cheaper"';
            }

            var table =
                '<table class="cost-table">' +
                    '<thead><tr>' +
                        '<th>Cost per day, per person</th>' +
                        '<th class="col-a">' + escapeHtml(p1.name) + '</th>' +
                        '<th class="col-b">' + escapeHtml(p2.name) + '</th>' +
                    '</tr></thead>' +
                    '<tbody>' + rows +
                        '<tr class="cost-total-row">' +
                            '<td>Total per day, per person</td>' +
                            '<td' + dcls1 + '>' + fmtR(dayTotal1) + '</td>' +
                            '<td' + dcls2 + '>' + fmtR(dayTotal2) + '</td>' +
                        '</tr>' +
                        '<tr>' +
                            '<td><span class="cost-cat">Flights (per person)</span></td>' +
                            '<td' + fcls1 + '>' + fmtR(flights1) + '</td>' +
                            '<td' + fcls2 + '>' + fmtR(flights2) + '</td>' +
                        '</tr>' +
                        '<tr>' +
                            '<td><span class="cost-cat">Per-day total &times; number of days</span></td>' +
                            '<td>' + fmtR(dayTotal1) + ' &times; ' + p1.duration + ' days = ' + fmtR(dayTotal1 * p1.duration) + '</td>' +
                            '<td>' + fmtR(dayTotal2) + ' &times; ' + p2.duration + ' days = ' + fmtR(dayTotal2 * p2.duration) + '</td>' +
                        '</tr>' +
                        '<tr class="cost-total-row">' +
                            '<td>Real total, per person</td>' +
                            '<td' + tcls1 + '>' + fmtR(total1) + '</td>' +
                            '<td' + tcls2 + '>' + fmtR(total2) + '</td>' +
                        '</tr>' +
                    '</tbody>' +
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
            if(!p1 || !p2){ return; }

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

</body>
</html>
