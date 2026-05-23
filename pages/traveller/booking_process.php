<?php
    //u24611400 Anke de Frey

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/traveller_dashboard_queries.php';
    require_once __DIR__ . '/../../includes/booking_process_queries.php';

    redirectIfNotTraveller();

    // Only process POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: traveller_dashboard.php');
        exit;
    }

    $userID = getCurrentUserID();

    if (isset($_POST['package_id'])) {
        $packageId = (int)$_POST['package_id'];
    } else {
        $packageId = null;
    }

    if (isset($_POST['num_travellers'])) {
        $numTravellers = (int)$_POST['num_travellers'];
    } else {
        $numTravellers = 1;
    }

    if (isset($_POST['start_date'])) {
        $startDate = sanitise($_POST['start_date']);
    } else {
        $startDate = date('Y-m-d');
    }

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

    if ($numTravellers === 1) {
        $bookingType = 'Solo';
    } else {
        $bookingType = 'Group';
    }

    // Create booking record (booking_process_queries.php)
    $bookingResult = createBooking($conn, $packageId, $bookingDate, $startDate, $endDate, $bookingType, $userID);

    if ($bookingResult['success']) {
        $bookingId = $bookingResult['booking_id'];

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
        $_SESSION['booking_error'] = $bookingResult['error'];
        header('Location: package_details.php?id=' . $packageId);
        exit;
    }
?>
