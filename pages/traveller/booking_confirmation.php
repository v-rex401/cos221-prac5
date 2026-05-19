<?php
    //u24611400 Anke de Frey

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/traveller_dashboard_queries.php';

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

    // Get booking details
    $sql = "SELECT b.*, p.package_name, p.Price, p.Duration
            FROM bookings b
            JOIN packages p ON b.Package_ID = p.Package_ID
            WHERE b.Booking_ID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();

    if (!$booking) {
        header('Location: traveller_dashboard.php');
        exit;
    }

    $stmt->close();

    // Get booking info from session
    $numTravellers = isset($_SESSION['booking_travellers']) ? $_SESSION['booking_travellers'] : 1;
    $totalPrice = $booking['Price'] * $numTravellers;

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
            <li><a href="packages.php">Packages</a></li>
            <li><a href="bookings.php">Bookings</a></li>
            <li><a href="reviews.php">Reviews</a></li>
        </ul>
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
                <a href="../logout.php" class="logout-link">Logout</a>
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
                    <span class="detail-value"><?php echo $numTravellers; ?> <?php echo $numTravellers === 1 ? 'person' : 'people'; ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Price per Person</span>
                    <span class="detail-value">R<?php echo number_format($booking['Price'], 2); ?></span>
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
