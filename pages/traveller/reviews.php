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

    if ($userResult['success']) {
        $userName = sanitise($userResult['user']['Name']);
    } else {
        $userName = 'Traveller';
    }

    // Get traveller's reviews
    $reviews = getTravellerReviews($conn, $userID);

    // Filter by rating if requested
    $filterRating = isset($_GET['rating']) ? (int)$_GET['rating'] : 0;
    $filteredReviews = [];

    foreach ($reviews as $review) {
        if ($filterRating === 0 || $review['Rating'] === $filterRating) {
            $filteredReviews[] = $review;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reviews - Tripistry</title>
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
            <li><a href="compare_packages.php">Compare Packages</a></li>
            <li><a href="bookings.php">My Bookings</a></li>
            <li><a href="reviews.php" class="active-link">Reviews</a></li>
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

        <!-- REVIEWS CONTENT -->
        <div class="reviews-container">
            <div class="page-header">
                <h1>My Reviews</h1>
                <p><?php echo count($reviews); ?> review<?php echo count($reviews) !== 1 ? 's' : ''; ?> submitted</p>
            </div>

            <?php if (count($reviews) > 0): ?>
                <!-- STATS -->
                <div class="reviews-stats">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo count($reviews); ?></div>
                        <div class="stat-label">Total Reviews</div>
                    </div>

                    <?php
                    $avgRating = 0;
                    if (count($reviews) > 0) {
                        $totalRating = 0;
                        foreach ($reviews as $review) {
                            $totalRating += $review['Rating'];
                        }
                        $avgRating = $totalRating / count($reviews);
                    }
                    ?>

                    <div class="stat-card">
                        <div class="stat-number"><?php echo number_format($avgRating, 1); ?></div>
                        <div class="stat-label">Average Rating</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-number">
                            <?php
                            $fiveStarCount = count(array_filter($reviews, function($r) { return $r['Rating'] === 5; }));
                            echo $fiveStarCount;
                            ?>
                        </div>
                        <div class="stat-label">5-Star Reviews</div>
                    </div>
                </div>

                <!-- FILTER -->
                <div class="filter-section">
                    <label>Filter by Rating:</label>
                    <div class="filter-buttons">
                        <a href="reviews.php" class="filter-btn <?php echo $filterRating === 0 ? 'active' : ''; ?>">All</a>
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <a href="reviews.php?rating=<?php echo $i; ?>" class="filter-btn <?php echo $filterRating === $i ? 'active' : ''; ?>">
                                <?php for ($j = 0; $j < $i; $j++): ?>
                                    <span class="star-filled">★</span>
                                <?php endfor; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- REVIEWS LIST -->
                <div class="reviews-list">
                    <?php foreach ($filteredReviews as $review): ?>
                        <div class="review-card">
                            <div class="review-card-header">
                                <div class="review-package-info">
                                    <h3><?php echo htmlspecialchars($review['package_name']); ?></h3>
                                    <a href="package_details.php?id=<?php echo $review['Package_ID']; ?>">View Package</a>
                                </div>
                                <div class="review-rating">
                                    <?php for ($i = 0; $i < $review['Rating']; $i++): ?>
                                        <span class="star-filled">★</span>
                                    <?php endfor; ?>
                                    <?php for ($i = $review['Rating']; $i < 5; $i++): ?>
                                        <span class="star-empty">☆</span>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <div class="review-metadata">
                                <span>Reviewed: <?php echo date('M d, Y', strtotime($review['Date'])); ?></span>
                                <span>Booked: <?php echo date('M d, Y', strtotime($review['Booking_Date'])); ?></span>
                            </div>

                            <?php if (!empty($review['Comment'])): ?>
                                <p class="review-comment"><?php echo htmlspecialchars($review['Comment']); ?></p>
                            <?php endif; ?>

                            <div class="review-actions">
                                <a href="package_details.php?id=<?php echo $review['Package_ID']; ?>" class="review-action-link">View Reviews</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (empty($filteredReviews) && $filterRating > 0): ?>
                    <div class="empty-state">
                        <h2>No reviews found</h2>
                        <p>You haven't submitted any <?php echo $filterRating; ?> star reviews yet.</p>
                        <a href="reviews.php">View all reviews</a>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="empty-state">
                    <h2>No Reviews Yet</h2>
                    <p>You haven't submitted any reviews</p>
                    <a href="traveller_dashboard.php">Browse Packages</a>
                </div>
            <?php endif; ?>

        </div>

    </div>

</div>

</body>
</html>
