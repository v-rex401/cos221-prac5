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
            <li><a href="compare_packages.php">Compare Packages</a></li>
            <li><a href="bookings.php" class="active-link">My Bookings</a></li>
            <li><a href="reviews.php">Reviews</a></li>
        </ul>

        <a href="../logout.php" class="sidebar-logout">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOP BAR -->
        <div class="topbar">
            <div class="topbar-spacer"></div>
            <div class="profile">
                Welcome, <?php echo htmlspecialchars($userName); ?>
            </div>
        </div>

        <!-- MY BOOKINGS PAGE CONTENT -->
        <div class="bookings-page">

            <div class="bookings-header">
                <h1>My Bookings</h1>
            </div>

            <?php
                // Separate bookings into upcoming and past
                $today = new DateTime();
                $upcomingBookings = [];
                $pastBookings = [];

                foreach ($bookings as $booking) {
                    $endDate = new DateTime($booking['End_Date']);
                    if ($endDate < $today) {
                        $pastBookings[] = $booking;
                    } else {
                        $upcomingBookings[] = $booking;
                    }
                }
            ?>

            <?php if (empty($bookings)): ?>
                <div class="empty-state">
                    <h2>No bookings yet</h2>
                    <p>You have not booked any packages</p>
                    <a href="traveller_dashboard.php">Browse packages</a>
                </div>
            <?php else: ?>
                <!-- UPCOMING BOOKINGS -->
                <?php if (!empty($upcomingBookings)): ?>
                    <div class="bookings-section">
                        <div class="bookings-header-secondary">
                            <h2>My Bookings</h2>
                            <span class="bookings-count-badge"><?php echo count($upcomingBookings); ?></span>
                        </div>

                        <div class="bookings-grid">
                            <?php foreach ($upcomingBookings as $booking): ?>
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

                                            <!-- Group members (booking_travelers) -->
                                            <?php $groupMembers = getGroupMembers($conn, $booking['Booking_ID']); ?>
                                            <?php if (!empty($groupMembers)): ?>
                                                <div class="booking-members">
                                                    <span class="booking-members-label">Group members (<?php echo count($groupMembers); ?>)</span>
                                                    <div class="booking-members-list">
                                                        <?php foreach ($groupMembers as $memberName): ?>
                                                            <span class="booking-member"><?php echo htmlspecialchars($memberName); ?></span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <div class="booking-card-footer">
                                                <span class="booking-price">R<?php echo number_format($booking['full_price'], 2); ?></span>
                                                <span class="booking-view-link">View package</span>
                                            </div>
                                        </div>

                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- PAST BOOKINGS -->
                <?php if (!empty($pastBookings)): ?>
                    <div class="bookings-section past-bookings-section">
                        <div class="bookings-header-secondary">
                            <h2>Past Bookings</h2>
                            <span class="bookings-count-badge"><?php echo count($pastBookings); ?></span>
                        </div>

                        <div class="bookings-grid">
                            <?php foreach ($pastBookings as $booking): ?>
                                <div class="booking-card-static">
                                    <div class="booking-card">

                                        <!-- Image -->
                                        <div class="booking-card-image">
                                            <?php if (!empty($booking['image_url'])): ?>
                                                <img src="<?php echo htmlspecialchars($booking['image_url']); ?>"
                                                    alt="<?php echo htmlspecialchars($booking['package_name']); ?>">
                                            <?php else: ?>
                                                <div class="no-image">No Image</div>
                                            <?php endif; ?>

                                            <div class="booking-type-badge completed">
                                                Completed
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
                                                <span class="booking-detail-label">Completed on</span>
                                                <span class="booking-detail-value">
                                                    <?php echo date('M d, Y', strtotime($booking['End_Date'])); ?>
                                                </span>
                                            </div>

                                            <!-- Group members (booking_travelers) -->
                                            <?php $groupMembers = getGroupMembers($conn, $booking['Booking_ID']); ?>
                                            <?php if (!empty($groupMembers)): ?>
                                                <div class="booking-members">
                                                    <span class="booking-members-label">Group members (<?php echo count($groupMembers); ?>)</span>
                                                    <div class="booking-members-list">
                                                        <?php foreach ($groupMembers as $memberName): ?>
                                                            <span class="booking-member"><?php echo htmlspecialchars($memberName); ?></span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <div class="booking-card-footer">
                                                <span class="booking-price">R<?php echo number_format($booking['full_price'], 2); ?></span>
                                                <button class="booking-review-btn" onclick="openReviewModal(<?php echo $booking['Booking_ID']; ?>, <?php echo $booking['Package_ID']; ?>)">Leave a Review</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

            <!-- REVIEW MODAL -->
            <?php if (!empty($pastBookings)): ?>
                <div id="review-modal" class="review-modal">
                    <div class="review-modal-overlay"></div>
                    <div class="review-modal-content">
                        <button class="review-modal-close" onclick="closeReviewModal()">&times;</button>
                        <h2>Leave a Review</h2>

                        <form id="review-form" method="POST" action="review_process.php">
                            <input type="hidden" id="review-booking-id" name="booking_id">
                            <input type="hidden" id="review-package-id" name="package_id">

                            <div class="review-form-group">
                                <label>Rating</label>
                                <div class="review-rating-input">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <label class="star-label">
                                            <input type="radio" name="rating" value="<?php echo $i; ?>" required>
                                            <span class="star-icon">★</span>
                                        </label>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <div class="review-form-group">
                                <label for="review-comment">Comment (optional)</label>
                                <textarea id="review-comment" name="comment" placeholder="Share your experience..." maxlength="500"></textarea>
                            </div>

                            <div class="review-form-actions">
                                <button type="button" class="review-btn-cancel" onclick="closeReviewModal()">Cancel</button>
                                <button type="submit" class="review-btn-submit">Submit Review</button>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    function openReviewModal(bookingId, packageId) {
                        document.getElementById('review-booking-id').value = bookingId;
                        document.getElementById('review-package-id').value = packageId;
                        document.getElementById('review-modal').style.display = 'flex';
                    }

                    function closeReviewModal() {
                        document.getElementById('review-modal').style.display = 'none';
                        document.getElementById('review-form').reset();
                    }

                    // Close modal when clicking overlay
                    document.querySelector('.review-modal-overlay').addEventListener('click', closeReviewModal);
                </script>
            <?php endif; ?>



        </div>

    </div>

</div>

</body>
</h