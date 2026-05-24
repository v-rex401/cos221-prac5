<?php
    //u24611400 Anke de Frey
    //My Bookings - lists every package the traveller has booked.

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/bookings_queries.php';

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

    //bookings_queries.php - every booking this traveller has made
    $bookings = getUserBookings($conn, $userID);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Tripistry</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/bookings.css">
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
            <li><a href="bookings.php" class="active-link">My Bookings</a></li>
            <li><a href="reviews.php">Reviews</a></li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOP BAR -->
        <div class="topbar">
            <div class="topbar-spacer"></div>
            <div class="profile">
                Welcome, <?php echo htmlspecialchars($userName); ?>
                <a href="../logout.php" class="logout-link">Logout</a>
            </div>
        </div>

        <!-- MY BOOKINGS PAGE CONTENT -->
        <div class="bookings-page">

            <div class="bookings-header">
                <h1>My Bookings</h1>
            </div>

            <?php if (empty($bookings)): ?>
                <div class="empty-state">
                    <h2>No bookings yet</h2>
                    <p>You have not booked any packages</p>
                    <a href="traveller_dashboard.php">Browse packages</a>
                </div>
            <?php else: ?>
                <div class="bookings-count">
                    <?php
                        $bookingCount = count($bookings);
                        echo $bookingCount;
                        if ($bookingCount === 1) {
                            echo ' booking';
                        } else {
                            echo ' bookings';
                        }
                    ?>
                </div>

                <div class="bookings-grid">
                    <?php foreach ($bookings as $booking): ?>
                        <a href="package_details.php?id=<?php echo (int)$booking['Package_ID']; ?>" class="booking-card-link">
                            <div class="booking-card">

                                <!-- Image -->
                                <div class="booking-card-image">
                                    <?php if (!empty($booking['image_url'])): ?>
                                        <img src="<?php echo htmlspecialchars($booking['image_url']); ?>"
                                            alt="<?php echo htmlspecialchars($booking['package_name']); ?>">
                                    <?php else: ?>
                                        <div class="no-image">No Image</div>
                                    <?php endif; ?>

                                    <div class="booking-type-badge">
                                        <?php echo htmlspecialchars($booking['Booking_Type']); ?>
                                    </div>
                                </div>

                                <!-- Details -->
                                <div class="booking-card-body">
                                    <div class="booking-ref">
                                        Booking #<?php echo str_pad($booking['Booking_ID'], 6, '0', STR_PAD_LEFT); ?>
                                    </div>

                                    <h3><?php echo htmlspecialchars($booking['package_name']); ?></h3>

                                    <div class="booking-detail-row">
                                        <span class="booking-detail-label">Travel dates</span>
                                        <span class="booking-detail-value">
                                            <?php echo date('M d, Y', strtotime($booking['Start_Date'])); ?>
                                            &ndash;
                                            <?php echo date('M d, Y', strtotime($booking['End_Date'])); ?>
                                        </span>
                                    </div>

                                    <div class="booking-detail-row">
                                        <span class="booking-detail-label">Duration</span>
                                        <span class="booking-detail-value"><?php echo (int)$booking['Duration']; ?> days</span>
                                    </div>

                                    <div class="booking-detail-row">
                                        <span class="booking-detail-label">Booked on</span>
                                        <span class="booking-detail-value">
                                            <?php echo date('M d, Y', strtotime($booking['Booking_Date'])); ?>
                                        </span>
                                    </div>

                                    <div class="booking-card-footer">
                                        <span class="booking-price">R<?php echo number_format($booking['Price'], 2); ?></span>
                                        <span class="booking-view-link">View package</span>
                                    </div>
                                </div>

                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>

</div>

</body>
</html>
