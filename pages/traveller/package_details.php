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

    if ($userHasBooked) {
        $userReview = userHasReviewedPackage($conn, $userID, $packageId);
        // Get user's booking for this package
        $sql = "SELECT Booking_ID FROM bookings
                WHERE User_ID = ? AND Package_ID = ?
                ORDER BY Booking_Date DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $userID, $packageId);
        $stmt->execute();
        $result = $stmt->get_result();
        $userBooking = $result->fetch_assoc();
        $stmt->close();
    }

    // Handle success/error messages
    $successMessage = isset($_GET['success']) ? sanitise($_GET['success']) : '';
    $errorMessage = isset($_GET['error']) ? sanitise($_GET['error']) : '';

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

        <!-- BACK BUTTON -->
        <div class="back-button-wrapper">
            <a href="traveller_dashboard.php" class="back-link">Back to Packages</a>
        </div>

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
                    <span class="meta-value price">R<?php echo number_format($package['Price'], 2); ?></span>
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
                <button onclick="openBookingModal()" class="btn btn-primary">Book Now</button>
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

            <!-- REVIEW SUBMISSION FORM (for users who have booked) -->
            <?php if ($userHasBooked && !$userReview && $userBooking): ?>
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

<!-- BOOKING MODAL -->
<div id="bookingModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Book This Package</h2>
            <button class="modal-close" onclick="closeBookingModal()">✕</button>
        </div>

        <form method="POST" action="booking-process.php" class="booking-form">
            <input type="hidden" name="package_id" value="<?php echo $package['Package_ID']; ?>">

            <div class="form-group">
                <label for="start_date">Travel Start Date</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="form-group">
                <label for="num_travellers">Number of Travellers</label>
                <input type="number" id="num_travellers" name="num_travellers" min="1" max="20" value="1" required>
            </div>

            <div class="booking-summary">
                <div class="summary-row">
                    <span>Price per Person</span>
                    <span>R<?php echo number_format($package['Price'], 2); ?></span>
                </div>
                <div class="summary-row">
                    <span>Number of Travellers</span>
                    <span id="traveller-count">1</span>
                </div>
                <div class="summary-row total">
                    <span>Total Price</span>
                    <span id="total-price">R<?php echo number_format($package['Price'], 2); ?></span>
                </div>
            </div>

            <div class="modal-buttons">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Confirm Booking</button>
                <button type="button" class="btn btn-secondary" onclick="closeBookingModal()" style="width: 100%;">Cancel</button>
            </div>
        </form>
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
    .form-group textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-family: inherit;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s ease;
        box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #1e73ff;
        box-shadow: 0 0 0 2px rgba(30, 115, 255, 0.1);
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
</style>

<script>
    const pricePerPerson = <?php echo $package['Price']; ?>;

    function openBookingModal() {
        document.getElementById('bookingModal').style.display = 'flex';
    }

    function closeBookingModal() {
        document.getElementById('bookingModal').style.display = 'none';
    }

    document.getElementById('num_travellers').addEventListener('change', function() {
        const numTravellers = parseInt(this.value) || 1;
        const totalPrice = pricePerPerson * numTravellers;

        document.getElementById('traveller-count').textContent = numTravellers;
        document.getElementById('total-price').textContent = 'R' + totalPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    });

    // Close modal when clicking outside
    document.getElementById('bookingModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeBookingModal();
        }
    });
</script>

</body>
</html>
