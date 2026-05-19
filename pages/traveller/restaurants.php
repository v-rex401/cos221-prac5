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

    // Get all restaurants
    $sql = "SELECT Restaurant_ID, Name, Cuisine, Image FROM restaurants ORDER BY Name";
    $result = $conn->query($sql);
    $allRestaurants = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $allRestaurants[] = $row;
        }
    }

    // Get unique cuisines
    $cuisines = [];
    foreach ($allRestaurants as $rest) {
        if (!in_array($rest['Cuisine'], $cuisines)) {
            $cuisines[] = $rest['Cuisine'];
        }
    }
    sort($cuisines);

    // Get filter parameters
    $searchQuery = '';
    $selectedCuisine = '';

    if (isset($_GET['search'])) {
        $searchQuery = sanitise($_GET['search']);
    }
    if (isset($_GET['cuisine'])) {
        $selectedCuisine = sanitise($_GET['cuisine']);
    }

    // Filter restaurants
    $filteredRestaurants = [];
    foreach ($allRestaurants as $rest) {
        $nameMatch = empty($searchQuery) || stripos($rest['Name'], $searchQuery) !== false;
        $cuisineMatch = empty($selectedCuisine) || strcasecmp($rest['Cuisine'], $selectedCuisine) === 0;

        if ($nameMatch && $cuisineMatch) {
            $filteredRestaurants[] = $rest;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Restaurants - Tripistry</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/restaurants.css">
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
            <li><a href="restaurants.php" class="active-link">Restaurants</a></li>
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
                <form method="GET">
                    <input type="text" name="search" placeholder="Search packages"
                        value="">
                    <button type="submit">Search</button>
                </form>
            </div>

            <div class="profile">
                Welcome, <?php echo htmlspecialchars($userName); ?>
                <a href="../logout.php" class="logout-link">Logout</a>
            </div>
        </div>

        <!-- RESTAURANTS PAGE CONTENT -->
        <div class="restaurants-page">

            <div class="restaurants-header">
                <h1>Dining Options</h1>
            </div>

            <!-- FILTERS -->
            <div class="filter-section">
                <div class="filter-group">
                    <label for="search">Search Restaurant</label>
                    <input type="text" id="search" name="search" placeholder="Search"
                        value="<?php echo htmlspecialchars($searchQuery); ?>" form="filterForm">
                </div>

                <div class="filter-group">
                    <label for="cuisine">Cuisine Type</label>
                    <select id="cuisine" name="cuisine" form="filterForm">
                        <option value="">All Cuisines</option>
                        <?php foreach ($cuisines as $cuisine): ?>
                            <option value="<?php echo htmlspecialchars($cuisine); ?>" <?php if ($selectedCuisine === $cuisine) { echo 'selected'; } ?> >
                                <?php echo htmlspecialchars($cuisine); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <form method="GET" id="filterForm" class="filter-buttons">
                    <button type="submit">Apply Filters</button>
                    <a href="restaurants.php" class="reset">Reset</a>
                </form>
            </div>

            <!-- RESTAURANTS GRID -->
            <?php if (empty($filteredRestaurants)): ?>
                <div class="empty-state">
                    <h2>No restaurants found</h2>
                    <p>Try adjusting your search or filters</p>
                    <a href="restaurants.php">View all restaurants</a>
                </div>
            <?php else: ?>
                <div class="restaurants-grid">
                    <?php foreach ($filteredRestaurants as $rest): ?>
                        <div class="restaurant-card">
                            <div class="restaurant-card-image">
                                <?php if ($rest['Image']): ?>
                                    <img src="<?php echo htmlspecialchars($rest['Image']); ?>" alt="<?php echo htmlspecialchars($rest['Name']); ?>">
                                <?php else: ?>
                                    <div class="no-image">No Image</div>
                                <?php endif; ?>
                            </div>

                            <div class="restaurant-card-content">
                                <h3><?php echo htmlspecialchars($rest['Name']); ?></h3>
                                <span class="restaurant-cuisine">
                                    <?php echo htmlspecialchars($rest['Cuisine']); ?>
                                </span>
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
