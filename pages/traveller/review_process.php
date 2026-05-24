<?php
    //u24611400 Anke de Frey

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/traveller_dashboard_queries.php';
    require_once __DIR__ . '/../../includes/review_process_queries.php';

    redirectIfNotTraveller();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: traveller_dashboard.php');
        exit;
    }

    $userID = getCurrentUserID();

    if (isset($_POST['package_id'])) {
        $packageID = (int)$_POST['package_id'];
    } else {
        $packageID = null;
    }

    if (isset($_POST['booking_id'])) {
        $bookingID = (int)$_POST['booking_id'];
    } else {
        $bookingID = null;
    }

    if (isset($_POST['rating'])) {
        $rating = (int)$_POST['rating'];
    } else {
        $rating = null;
    }

    if (isset($_POST['comment'])) {
        $comment = sanitise($_POST['comment']);
    } else {
        $comment = '';
    }

    // Validate inputs
    if (!$packageID || !$bookingID || !$rating || $rating < 1 || $rating > 5) {
        header('Location: package_details.php?id=' . $packageID . '&error=invalid_input');
        exit;
    }

    // Verify user owns this booking (review_process_queries.php)
    $booking = getOwnedBooking($conn, $bookingID, $userID, $packageID);

    if (!$booking) {
        header('Location: package_details.php?id=' . $packageID . '&error=unauthorized');
        exit;
    }

    // A review can only be left once the trip is over (End_Date in the past)
    if (empty($booking['End_Date']) || $booking['End_Date'] >= date('Y-m-d')) {
        header('Location: package_details.php?id=' . $packageID . '&error=trip_not_completed');
        exit;
    }

    // Check if user already reviewed this package
    $existingReview = userHasReviewedPackage($conn, $userID, $packageID);
    if ($existingReview) {
        header('Location: package_details.php?id=' . $packageID . '&error=already_reviewed');
        exit;
    }

    // Submit review (review is stored against the booking and the reviewer)
    $reviewResult = submitReview($conn, $bookingID, $userID, $rating, $comment);

    if ($reviewResult['success']) {
        header('Location: package_details.php?id=' . $packageID . '&success=review_submitted');
        exit;
    } else {
        header('Location: package_details.php?id=' . $packageID . '&error=submission_failed');
        exit;
    }
?>
