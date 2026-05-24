<?php
    //u24611400 Anke de Frey

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/traveller_dashboard_queries.php';
    require_once __DIR__ . '/../../includes/attractions_queries.php';

    redirectIfNotTraveller();
    $userID = getCurrentUserID();
    $userResult = getTravellerByUserID($userID);
    if ($userResult['success']) {
        $userName = sanitise($userResult['user']['Name']);
    } else {
        $userName = 'Traveller';
    }

    // Get all attractions (attractions_queries.php)
    $allAttractions = getAllAttractions($conn);

    // Get filter parameters
    $searchQuery = '';
    if (isset($_GET['search'])) {
        $searchQuery = sanitise($_GET['search']);
    }

    // Filter attractions
    $filteredAttractions = [];
    foreach ($allAttractions as $attr) {
        $nameMatch = empty($searchQuery) || stripos($attr['Name'], $searchQuery) !== false;
        if ($nameMatch) {
            $filteredAttractions[] = $attr;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Attractions - Tripistry</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/attractions.css">

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
            <li><a href="attractions.php" class="active-link">Attractions</a></li>
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
            <div class="topbar-spacer"></div>
            <div class="profile">
                Welcome, <?php echo htmlspecialchars($userName); ?>
                <a href="../logout.php" class="logout-link">Logout</a>
            </div>
        </div>

        <!-- ATTRACTIONS PAGE CONTENT -->
        <div class="attractions-page">
            <div class="attractions-header">
                <h1>Tourist Attractions</h1>
            </div>

            <!-- FILTERS -->
            <div class="filter-section">
                <form method="GET">
                    <div class="filter-group">
                        <label for="search">Search Attractions</label>
                        <input type="text" id="search" name="search" placeholder="search"
                            value="<?php echo htmlspecialchars($searchQuery); ?>">
                    </div>

                    <div class="filter-buttons">
                        <button type="submit">Search</button>
                        <a href="attractions.php" class="reset">Reset</a>
                    </div>
                </form>
            </div>

            <!-- ATTRACTIONS GRID -->
            <?php if (empty($filteredAttractions)): ?>
                <div class="empty-state">
                    <h2>No attractions found</h2>
                    <p>Try adjusting your search</p>
                    <a href="attractions.php">View all attractions</a>
                </div>
            <?php else: ?>
                <div class="attractions-grid">
                    <?php foreach ($filteredAttractions as $attr): ?>
                        <div class="attraction-card">
                            <div class="attraction-card-image">
                                <?php if ($attr['Image']): ?>
                                    <img src="<?php echo htmlspecialchars($attr['Image']); ?>" alt="<?php echo htmlspecialchars($attr['Name']); ?>">
                                <?php else: ?>
                                    <div class="no-image">No Image</div>
                                <?php endif; ?>
                            </div>

                            <div class="attraction-card-content">
                                <h3><?php echo htmlspecialchars($attr['Name']); ?></h3>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>

</div>

</body>
</html>
