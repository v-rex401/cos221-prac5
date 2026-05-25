<?php
    //u24611400 Anke de Frey
    //Standalone booking page - reached from the "Book Now" buttons on the
    //package view page and the traveller dashboard. Posts to booking_process.php.

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/traveller_dashboard_queries.php';
    require_once __DIR__ . '/../../includes/package_details_queries.php';

    redirectIfNotTraveller();

    $userID = getCurrentUserID();
    $userResult = getTravellerByUserID($userID);

    if($userResult['success']){
        $userName = sanitise($userResult['user']['Name']);
    }else{
        $userName = 'Traveller';
    }

    // Get package ID from URL
    if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
        header('Location: traveller_dashboard.php');
        exit;
    }

    $packageId = (int)$_GET['id'];
    $package = getPackageDetails($conn, $packageId);

    if(!$package){
        header('Location: traveller_dashboard.php');
        exit;
    }

    // Set departure dates for this package (package_details_queries.php)
    $packageDepartureDates = getPackageDepartureDates($conn, $packageId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book <?php echo htmlspecialchars($package['package_name']); ?> - Tripistry</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/book_package.css">
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
            <li><a href="compare_packages.php">Compare Packages</a></li>
            <li><a href="bookings.php">My Bookings</a></li>
            <li><a href="reviews.php">Reviews</a></li>
        </ul>

        <a href="../logout.php" class="sidebar-logout">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- TOP BAR -->
        <div class="topbar">
            <div class="topbar-spacer"></div>
            <div class="profile">
                Welcome, <?php echo htmlspecialchars($userName); ?>
            </div>
        </div>

        <div class="book-page">
            <a href="package_details.php?id=<?php echo $packageId; ?>" class="book-back">Back to package</a>

            <div class="book-card">
                <h1>Book: <?php echo htmlspecialchars($package['package_name']); ?></h1>

                <form method="POST" action="booking_process.php" class="booking-form">
                    <input type="hidden" name="package_id" value="<?php echo $package['Package_ID']; ?>">

                    <!-- Departure date - confirm one of the package's set dates -->
                    <div class="form-group">
                        <label for="start_date">Departure Date</label>
                        <select id="start_date" name="start_date" required>
                            <?php if (empty($packageDepartureDates)): ?>
                                <option value="" disabled selected>No set departure dates available yet</option>
                            <?php else: ?>
                                <?php foreach ($packageDepartureDates as $dateIndex => $departureDate): ?>
                                    <option value="<?php echo htmlspecialchars($departureDate); ?>" <?php if ($dateIndex === 0) { echo 'selected'; } ?>>
                                        <?php echo date('M d, Y', strtotime($departureDate)); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="num_travellers">Number of Travellers</label>
                        <input type="number" id="num_travellers" name="num_travellers" min="1" max="20" value="1" required>
                    </div>

                    <!-- Traveller details - one name + cellphone per traveller -->
                    <div class="form-group">
                        <label>Traveller Details</label>
                        <div id="traveller-fields"></div>
                    </div>

                    <div class="booking-summary">
                        <div class="summary-row">
                            <span>Trip Length</span>
                            <span><?php echo (int)$package['Duration']; ?> days</span>
                        </div>
                        <div class="summary-row">
                            <span>Price per Person</span>
                            <span>R<?php echo number_format($package['full_price'], 2); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Number of Travellers</span>
                            <span id="traveller-count">1</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total Price</span>
                            <span id="total-price">R<?php echo number_format($package['full_price'], 2); ?></span>
                        </div>
                    </div>

                    <div class="book-buttons">
                        <button type="submit" class="btn btn-primary">Confirm Booking</button>
                        <a href="package_details.php?id=<?php echo $packageId; ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

<script>
    const pricePerPerson = <?php echo $package['full_price']; ?>;
    const loggedInName = <?php echo json_encode($userName); ?>;

    function escapeAttr(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    // build one name + cellphone block per traveller
    function renderTravellerFields() {
        const numTravellers = parseInt(document.getElementById('num_travellers').value) || 1;
        const container = document.getElementById('traveller-fields');

        // remember anything already typed so changing the count keeps it
        const typedNames = [];
        const typedCells = [];
        container.querySelectorAll('input[name="traveller_name[]"]').forEach(function (input, i) {
            typedNames[i] = input.value;
        });
        container.querySelectorAll('input[name="traveller_cell[]"]').forEach(function (input, i) {
            typedCells[i] = input.value;
        });

        let html = '';
        for (let i = 0; i < numTravellers; i++) {
            let nameValue = typedNames[i] || '';
            // traveller 1 defaults to the logged-in traveller
            if (i === 0 && nameValue === '') {
                nameValue = loggedInName;
            }
            const cellValue = typedCells[i] || '';
            html +=
                '<div class="traveller-row">' +
                    '<div class="traveller-row-title">Traveller ' + (i + 1) + '</div>' +
                    '<input type="text" name="traveller_name[]" placeholder="Full name" value="' + escapeAttr(nameValue) + '" required>' +
                    '<input type="tel" name="traveller_cell[]" placeholder="Cellphone number" value="' + escapeAttr(cellValue) + '" required>' +
                '</div>';
        }
        container.innerHTML = html;
    }

    // refresh the price summary and traveller blocks when the count changes
    function updateBookingForm() {
        const numTravellers = parseInt(document.getElementById('num_travellers').value) || 1;
        const totalPrice = pricePerPerson * numTravellers;

        document.getElementById('traveller-count').textContent = numTravellers;
        document.getElementById('total-price').textContent =
            'R' + totalPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        renderTravellerFields();
    }

    document.getElementById('num_travellers').addEventListener('input', updateBookingForm);

    // initial traveller block
    renderTravellerFields();
</script>

</body>
</html>
