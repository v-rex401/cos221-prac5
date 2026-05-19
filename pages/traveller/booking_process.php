<?php
    //u24611400 Anke de Frey

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/traveller_dashboard_queries.php';

    redirectIfNotTraveller();

    // Only process POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: traveller_dashboard.php');
        exit;
    }

    $userID = getCurrentUserID();
    $packageId = isset($_POST['package_id']) ? (int)$_POST['package_id'] : null;
    $numTravellers = isset($_POST['num_travellers']) ? (int)$_POST['num_travellers'] : 1;
    $startDate = isset($_POST['start_date']) ? sanitise($_POST['start_date']) : date('Y-m-d');

    // Validate inputs
    if (!$packageId || $numTravellers < 1 || $numTravellers > 20) {
        header('Location: traveller_dashboard.php');
        exit;
    }

    // Get package details
    $package = getPackageDetails($conn, $packageId);
    if (!$package) {
        header('Location: traveller_dashboard.php');
        exit;
    }

    // Calculate end date based on package duration
    $startDateObj = new DateTime($startDate);
    $endDateObj = clone $startDateObj;
    $endDateObj->add(new DateInterval('P' . $package['Duration'] . 'D'));
    $endDate = $endDateObj->format('Y-m-d');

    $bookingDate = date('Y-m-d');
    $bookingType = ($numTravellers === 1) ? 'Solo' : 'Group';

    // Create booking record
    $sql = "INSERT INTO bookings (Package_ID, Booking_Date, Start_Date, End_Date, Booking_Type, User_ID)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $_SESSION['booking_error'] = "Database error: " . $conn->error;
        header('Location: package_details.php?id=' . $packageId);
        exit;
    }

    $stmt->bind_param("issssi", $packageId, $bookingDate, $startDate, $endDate, $bookingType, $userID);

    if ($stmt->execute()) {
        $bookingId = $stmt->insert_id;

        // Store booking info in session for confirmation page
        $_SESSION['booking_success'] = true;
        $_SESSION['booking_id'] = $bookingId;
        $_SESSION['booking_package'] = $package['package_name'];
        $_SESSION['booking_travellers'] = $numTravellers;
        $_SESSION['booking_start_date'] = $startDate;
        $_SESSION['booking_end_date'] = $endDate;

        header('Location: booking_confirmation.php?id=' . $bookingId);
        exit;
    } else {
        $_SESSION['booking_error'] = "Failed to create booking. Please try again.";
        header('Location: package_details.php?id=' . $packageId);
        exit;
    }

    $stmt->close();
?>
