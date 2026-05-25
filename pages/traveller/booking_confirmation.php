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

    // Get the travellers stored for this booking (booking_confirmation_queries.php)
    $travellerDetails = getBookingTravellerDetails($conn, $bookingId);

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
    <style>
        .container {
            display: flex;
            height: 100vh;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
        }

        .topbar {
            background: white;
            padding: 15px 30px;
            border-bottom: 1px solid #f0f0f0;
        }

        .content-wrapper {
            padding: 50px 30px;
            max-width: 600px;
            margin: 0 auto;
        }

        .confirmation-card {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .confirmation-title {
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .confirmation-text {
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .group-info {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 6px;
            margin: 30px 0;
            text-align: left;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #666;
            font-weight: 500;
        }

        .info-value {
            color: #333;
            font-weight: 600;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: #1e73ff;
            color: white;
        }

        .btn-primary:hover {
            background: #1560dd;
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
            border: 1px solid #ddd;
        }

        .btn-secondary:hover {
            background: #e8e8e8;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logout-link {
            color: #1e73ff;
            text-decoration: none;
            font-size: 13px;
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .logout-link:hover {
            background: #f0f7ff;
        }
    </style>
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
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div></div>
                <div class="profile">
                    Welcome, <?php echo htmlspecialchars($userName); ?>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content-wrapper">
            <div class="confirmation-card">
                <h1 class="confirmation-title">Booking Confirmed!</h1>
                <p class="confirmation-text">
                    Your package has been successfully booked<br>
                    Booking Reference: #<?php echo str_pad($booking['Booking_ID'], 6, '0', STR_PAD_LEFT); ?>
                </p>

                <div class="group-info">

                    <div class="info-row">
                        <span class="info-label">Package</span>
                        <span class="info-value"><?php echo htmlspecialchars($booking['package_name']); ?></span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Duration</span>
                        <span class="info-value"><?php echo $booking['Duration']; ?> days</span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Travel Dates</span>
                        <span class="info-value"><?php echo date('M d, Y', strtotime($booking['Start_Date'])); ?> - <?php echo date('M d, Y', strtotime($booking['End_Date'])); ?></span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Travellers</span>
                        <span class="info-value"><?php echo $numTravellers; ?> <?php if ($numTravellers === 1) { echo 'person'; } else { echo 'people'; } ?></span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Price per Person</span>
                        <span class="info-value">R<?php echo number_format($booking['full_price'], 2); ?></span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Total Price</span>
                        <span class="info-value">R<?php echo number_format($totalPrice, 2); ?></span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Booking Type</span>
                        <span class="info-value"><?php echo htmlspecialchars($booking['Booking_Type']); ?></span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Booked On</span>
                        <span class="info-value"><?php echo date('M d, Y', strtotime($booking['Booking_Date'])); ?></span>
                    </div>

                    <?php if (!empty($travellerDetails)): ?>
                        <?php foreach ($travellerDetails as $index => $traveller): ?>
                            <div class="info-row">
                                <span class="info-label">Traveller <?php echo $index + 1; ?></span>
                                <span class="info-value">
                                    <?php echo htmlspecialchars($traveller['Name']); ?>
                                    &middot; <?php echo htmlspecialchars($traveller['Cell']); ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="button-group">
                    <a href="bookings.php" class="btn btn-primary">View My Bookings</a>
                    <a href="traveller_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>
