<?php
    //u24611400 Anke de Frey

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/traveller_dashboard_queries.php';
    require_once __DIR__ . '/../../includes/booking_confirmation_queries.php';

    redirectIfNotTraveller();

    $userID = getCurrentUserID();
    $userResult = getTravellerByUserID($userID);

    if($userResult['success']){
        $userName = sanitise($userResult['user']['Name']);
    }else{
        $userName = 'Traveller';
    }

    // Get booking ID from URL
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: traveller_dashboard.php');
        exit;
    }

    $bookingId = (int)$_GET['id'];

    // Get booking details (booking_confirmation_queries.php)
    $booking = getBookingConfirmation($conn, $bookingId);

    if (!$booking) {
        header('Location: traveller_dashboard.php');
        exit;
    }

    // Get booking info from session
    if (isset($_SESSION['booking_travellers'])) {
        $numTravellers = $_SESSION['booking_travellers'];
    } else {
        $numTravellers = 1;
    }
    $totalPrice = $booking['full_price'] * $numTravellers;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed - Tripistry</title>
    <link rel="stylesheet" href="../../css/style.css">
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
            <div class="search-bar">
                <form method="GET" action="traveller_dashboard.php">
                    <input type="text" name="search" placeholder="Search packages">
                    <button type="submit">Search</button>
                </form>
            </div>

            <div class="profile">
                Welcome, <?php echo htmlspecialchars($userName); ?>
            </div>
        </div>

        <!-- CONFIRMATION -->
        <div class="confirmation-container">
            <div class="confirmation-header">
                <div class="success-icon">✓</div>
                <h1>Booking Confirmed!</h1>
                <p>Your package has been successfully booked</p>
            </div>

            <div class="booking-id">
                <div class="booking-id-label">Booking Reference</div>
                <div class="booking-id-value">#<?php echo str_pad($booking['Booking_ID'], 6, '0', STR_PAD_LEFT); ?></div>
            </div>

            <div class="booking-details">
                <div class="detail-row">
                    <span class="detail-label">Package</span>
                    <span class="detail-value"><?php echo htmlspecialchars($booking['package_name']); ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Duration</span>
                    <span class="detail-value"><?php echo $booking['Duration']; ?> days</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Travel Dates</span>
                    <span class="detail-value"><?php echo date('M d, Y', strtotime($booking['Start_Date'])); ?> - <?php echo date('M d, Y', strtotime($booking['End_Date'])); ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Travellers</span>
                    <span class="detail-value"><?php echo $numTravellers; ?> <?php if ($numTravellers === 1) { echo 'person'; } else { echo 'people'; } ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Price per Person</span>
                    <span class="detail-value">R<?php echo number_format($booking['full_price'], 2); ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Total Price</span>
                    <span class="detail-value price">R<?php echo number_format($totalPrice, 2); ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Booking Type</span>
                    <span class="detail-value"><?php echo htmlspecialchars($booking['Booking_Type']); ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Booked On</span>
                    <span class="detail-value"><?php echo date('M d, Y', strtotime($booking['Booking_Date'])); ?></span>
                </div>
            </div>

            <div class="confirmation-note">
                A confirmation email has been sent to your registered email address. You can view and manage your booking from the Bookings page.
            </div>

            <div class="action-buttons">
                <a href="bookings.php" class="btn btn-primary">View My Bookings</a>
                <a href="traveller_dashboard.php" class="btn btn-secondary">Continue Shopping</a>
            </div>
        </div>

    </div>

</div>

</body>
</html>
