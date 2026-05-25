<?php
    //u24611400 Anke de Frey

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

    // Check if current user has booked this package
    $userHasBooked = userHasBookedPackage($conn, $userID, $packageId);
    $userReview = null;
    $userBooking = null;
    $tripCompleted = false;

    if ($userHasBooked) {
        $userReview = userHasReviewedPackage($conn, $userID, $packageId);
        // Get user's booking for this package (package_details_queries.php)
        $userBooking = getLatestUserBooking($conn, $userID, $packageId);

        // the trip counts as completed once its end date has passed
        if ($userBooking && !empty($userBooking['End_Date']) && $userBooking['End_Date'] < date('Y-m-d')) {
            $tripCompleted = true;
        }
    }

    // Handle success/error messages
    if (isset($_GET['success'])) {
        $successMessage = sanitise($_GET['success']);
    } else {
        $successMessage = '';
    }

    if (isset($_GET['error'])) {
        $errorMessage = sanitise($_GET['error']);
    } else {
        $errorMessage = '';
    }

    // Set departure dates for this package (package_details_queries.php).
    // Empty until the agency-side scheduling backend is built.
    $packageDepartureDates = getPackageDepartureDates($conn, $packageId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($package['package_name']); ?> - Tripistry</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/package_details.css">
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
            <h1 class="topbar-heading">View</h1>
            <div class="profile">
                Welcome, <?php echo htmlspecialchars($userName); ?>
            </div>
        </div>

        <!-- BACK BUTTON -->
        <div class="back-button-wrapper">
            <a href="traveller_dashboard.php" class="back-link">Back to Packages</a>
        </div>

        <br>

        <div class="package-details-hero">
            <?php if (!empty($package['images'])): ?>
                <img src="<?php echo htmlspecialchars($package['images'][0]['Image_URL']); ?>" alt="<?php echo htmlspecialchars($package['package_name']); ?>" class="package-hero-image">
            <?php else: ?>
                <div class="package-no-image">No Image Available</div>
            <?php endif; ?>

            <div class="package-hero-header">
                <div>
                    <h1><?php echo htmlspecialchars($package['package_name']); ?></h1>
                    <p class="package-agency"><?php echo htmlspecialchars($package['agency_name']); ?></p>
                </div>
                <div class="package-duration-badge">
                    <?php echo $package['Duration']; ?> days
                </div>
            </div>

            <!-- META INFORMATION -->
            <div class="package-meta">
                <div class="meta-item">
                    <span class="meta-label">Price</span>
                    <span class="meta-value price">R<?php echo number_format($package['full_price'], 2); ?></span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Duration</span>
                    <span class="meta-value"><?php echo $package['Duration']; ?> Days</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Rating</span>
                    <span class="meta-value"><?php echo number_format($package['avg_rating'], 1); ?></span>
                    <span style="font-size: 12px; color: #999;"><?php echo $package['review_count']; ?> reviews</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Availability</span>
                    <?php $detailSpots = getSpotsStatus($package['spots_left']); ?>
                    <span class="meta-value <?php echo $detailSpots['class']; ?>"><?php echo $detailSpots['text']; ?></span>
                    <span style="font-size: 12px; color: #999;"><?php echo (int)$package['Capacity']; ?> total</span>
                </div>
            </div>

            <!-- INCLUSIONS -->
            <div>
                <h3>Includes</h3>
                <div class="inclusions">
                    <?php if (!empty($package['flights'])): ?>
                        <div class="inclusion-badge">Flights</div>
                    <?php endif; ?>
                    <?php if (!empty($package['accommodations'])): ?>
                        <div class="inclusion-badge">Accommodation</div>
                    <?php endif; ?>
                    <?php if (!empty($package['restaurants'])): ?>
                        <div class="inclusion-badge">Meals</div>
                    <?php endif; ?>
                    <?php if (!empty($package['attractions'])): ?>
                        <div class="inclusion-badge">Tours & Attractions</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="action-buttons">
                <a href="book_package.php?id=<?php echo $package['Package_ID']; ?>" class="btn btn-primary">Book Now</a>
                <a href="traveller_dashboard.php" class="btn btn-secondary">Back</a>
            </div>
        </div>

        <!-- DESCRIPTION SECTION -->
        <div class="package-section">
            <h2>About This Package</h2>
            <div class="section-content">
                <?php echo nl2br(htmlspecialchars($package['Description'])); ?>
            </div>
        </div>

        <!-- DESTINATIONS SECTION -->
        <?php if (!empty($package['destinations'])): ?>
            <div class="package-section">
                <h2>Destinations Included</h2>
                <div class="destinations-grid">
                    <?php foreach ($package['destinations'] as $dest): ?>
                        <div>
                            <h3><?php echo htmlspecialchars($dest['Name']); ?></h3>
                            <p><?php echo htmlspecialchars($dest['Country']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- GALLERY SECTION -->
        <?php if (count($package['images']) > 1): ?>
            <div class="package-section">
                <h2>Gallery</h2>
                <div class="gallery">
                    <?php foreach ($package['images'] as $image): ?>
                        <img src="<?php echo htmlspecialchars($image['Image_URL']); ?>" alt="<?php echo htmlspecialchars($package['package_name']); ?>" class="gallery-image">
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- REVIEWS SECTION -->
        <div class="package-section">
            <h2>Reviews</h2>

            <?php if ($successMessage === 'review_submitted'): ?>
                <div class="success-message">✓ Your review has been submitted successfully!</div>
            <?php endif; ?>

            <?php if ($errorMessage === 'already_reviewed'): ?>
                <div class="error-message">You have already reviewed this package.</div>
            <?php endif; ?>

            <?php if ($errorMessage === 'trip_not_completed'): ?>
                <div class="error-message">You can only review this package once your trip is complete.</div>
            <?php endif; ?>

            <!-- REVIEW SUBMISSION FORM (only available once the trip is completed) -->
            <?php if ($userHasBooked && !$userReview && $userBooking && $tripCompleted): ?>
                <div class="review-form-card">
                    <h3>Share Your Experience</h3>
                    <form method="POST" action="review_process.php" class="review-form">
                        <input type="hidden" name="package_id" value="<?php echo $packageId; ?>">
                        <input type="hidden" name="booking_id" value="<?php echo $userBooking['Booking_ID']; ?>">

                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <div class="star-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" required>
                                    <label for="star<?php echo $i; ?>" class="star">★</label>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="comment">Your Review</label>
                            <textarea id="comment" name="comment" placeholder="Share your thoughts about this package..." rows="4" maxlength="500"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            <?php elseif ($userHasBooked && !$userReview && $userBooking && !$tripCompleted): ?>
                <div class="review-form-card">
                    <h3>Share Your Experience</h3>
                </div>
            <?php endif; ?>

            <!-- EXISTING REVIEWS -->
            <?php if (!empty($package['reviews'])): ?>
                <div class="reviews-list">
                    <?php foreach ($package['reviews'] as $review): ?>
                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-rating">
                                    <?php for ($i = 0; $i < $review['Rating']; $i++): ?>
                                        <span class="star-filled">★</span>
                                    <?php endfor; ?>
                                    <?php for ($i = $review['Rating']; $i < 5; $i++): ?>
                                        <span class="star-empty">☆</span>
                                    <?php endfor; ?>
                                </div>
                                <span class="review-date"><?php echo date('M d, Y', strtotime($review['Date'])); ?></span>
                            </div>
                            <p class="review-comment"><?php echo htmlspecialchars($review['Comment']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-reviews">
                    <p>No reviews yet. Be the first to review this package!</p>
                </div>
            <?php endif; ?>
        </div>

    </div>

</div>

<style>
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    .modal-content {
        background: white;
        border-radius: 8px;
        padding: 30px;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f0f0f0;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 20px;
        color: #333;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #999;
        transition: color 0.2s ease;
    }

    .modal-close:hover {
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
        font-size: 13px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-family: inherit;
        font-size: 14px;
        outline: none;
        background: white;
        transition: border-color 0.2s ease;
        box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #1e73ff;
        box-shadow: 0 0 0 2px rgba(30, 115, 255, 0.1);
    }

    /* one block of name + cellphone inputs per traveller */
    .traveller-row {
        padding: 12px;
        border: 1px solid #eee;
        border-radius: 6px;
        margin-bottom: 10px;
        background: #fafafa;
    }

    .traveller-row-title {
        font-size: 12px;
        font-weight: 600;
        color: #1e73ff;
        margin-bottom: 8px;
    }

    .traveller-row input {
        margin-bottom: 8px;
    }

    .traveller-row input:last-child {
        margin-bottom: 0;
    }

    .booking-summary {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        font-size: 14px;
        color: #666;
    }

    .summary-row.total {
        padding-top: 10px;
        border-top: 1px solid #ddd;
        font-weight: bold;
        font-size: 16px;
        color: #27ae60;
    }

    .modal-buttons {
        display: flex;
        gap: 10px;
        flex-direction: column;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
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

    /* spots-left colours on the meta row */
    .meta-value.spots-open {
        color: #27ae60;
    }

    .meta-value.spots-low {
        color: #e67e22;
    }

    .meta-value.spots-full {
        color: #c92a2a;
    }

    /* Reviews Styling */
    .success-message {
        background: #f0fdf4;
        border-left: 3px solid #22c55e;
        color: #166534;
        padding: 12px 14px;
        border-radius: 4px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .error-message {
        background: #fee;
        border-left: 3px solid #ff6b6b;
        color: #c92a2a;
        padding: 12px 14px;
        border-radius: 4px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .review-form-card {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        border: 1px solid #f0f0f0;
    }

    .review-form-card h3 {
        margin-top: 0;
        margin-bottom: 20px;
        color: #333;
        font-size: 16px;
    }

    .review-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .review-form .form-group {
        margin-bottom: 0;
    }

    .star-rating {
        display: flex;
        gap: 5px;
        font-size: 30px;
    }

    .star-rating input {
        display: none;
    }

    .star-rating .star {
        cursor: pointer;
        color: #ddd;
        transition: color 0.2s ease;
        padding: 5px;
    }

    .star-rating input:checked ~ .star,
    .star-rating .star:hover {
        color: #ffc107;
    }

    .review-form textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-family: inherit;
        font-size: 14px;
        resize: vertical;
        box-sizing: border-box;
    }

    .review-form textarea:focus {
        border-color: #1e73ff;
        box-shadow: 0 0 0 2px rgba(30, 115, 255, 0.1);
        outline: none;
    }

    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .review-item {
        background: white;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #f0f0f0;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .review-rating {
        font-size: 14px;
        letter-spacing: 2px;
    }

    .star-filled {
        color: #ffc107;
    }

    .star-empty {
        color: #ddd;
    }

    .review-date {
        color: #999;
        font-size: 12px;
    }

    .review-comment {
        margin: 0;
        color: #666;
        font-size: 14px;
        line-height: 1.6;
    }

    .no-reviews {
        text-align: center;
        padding: 40px 20px;
        color: #999;
        font-size: 14px;
    }

    .review-pending-note {
        margin: 0;
        color: #666;
        font-size: 14px;
        line-height: 1.6;
    }
</style>

</body>
</html>
