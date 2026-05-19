<?php
    //u24611400 Anke de Frey

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/traveller_dashboard_queries.php';

    redirectIfNotTraveller();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: traveller_dashboard.php');
        exit;
    }

    $userID = getCurrentUserID();
    $packageID = isset($_POST['package_id']) ? (int)$_POST['package_id'] : null;
    $bookingID = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : null;
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : null;
    $comment = isset($_POST['comment']) ? sanitise($_POST['comment']) : '';

    // Validate inputs
    if (!$packageID || !$bookingID || !$rating || $rating < 1 || $rating > 5) {
        header('Location: package_details.php?id=' . $packageID . '&error=invalid_input');
        exit;
    }

    // Verify user owns this booking
    $sql = "SELECT b.Booking_ID FROM bookings
            WHERE Booking_ID = ? AND User_ID = ? AND Package_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $bookingID, $userID, $packageID);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
    $stmt->close();

    if (!$booking) {
        header('Location: package_details.php?id=' . $packageID . '&error=unauthorized');
        exit;
    }

    // Check if user already reviewed this package
    $existingReview = userHasReviewedPackage($conn, $userID, $packageID);
    if ($existingReview) {
        header('Location: package_details.php?id=' . $packageID . '&error=already_reviewed');
        exit;
    }

    // Submit review
    $reviewResult = submitReview($conn, $bookingID, $rating, $comment);

    if ($reviewResult['success']) {
        header('Location: package_details.php?id=' . $packageID . '&success=review_submitted');
        exit;
    } else {
        header('Location: package_details.php?id=' . $packageID . '&error=submission_failed');
        exit;
    }
?>
