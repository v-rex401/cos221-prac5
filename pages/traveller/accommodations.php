<?php
    //u24611400 Anke de Frey

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/traveller_dashboard_queries.php';
    require_once __DIR__ . '/../../includes/accommodations_queries.php';

    //session.php
    redirectIfNotTraveller();

    //session.php
    $userID = getCurrentUserID();

    //auth.php
    $userResult = getTravellerByUserID($userID);

    //validation.php
    if ($userResult['success']) {
        $userName = sanitise($userResult['user']['Name']);
    } else {
        $userName = 'Traveller';
    }

    // Get all accommodations (accommodations_queries.php)
    $allAccommodations = getAllAccommodations($conn);

    // Get unique types
    $types = [];
    foreach ($allAccommodations as $acc) {
        if (!in_array($acc['Type'], $types)) {
            $types[] = $acc['Type'];
        }
    }
    sort($types);

    // Get filter parameters
    $searchQuery = '';
    $selectedType = '';
    $selectedCountry = '';
    $minPrice = 0;
    $maxPrice = 999999;
    $sortBy = 'price_asc';

    if (isset($_GET['search'])) {
        $searchQuery = sanitise($_GET['search']);
    }
    if (isset($_GET['type'])) {
        $selectedType = sanitise($_GET['type']);
    }
    if (isset($_GET['country'])) {
        $selectedCountry = sanitise($_GET['country']);
    }
    if (isset($_GET['minPrice'])) {
        $minPrice = (float)$_GET['minPrice'];
    }
    if (isset($_GET['maxPrice'])) {
        $maxPrice = (float)$_GET['maxPrice'];
    }
    if (isset($_GET['sort'])) {
        $sortBy = sanitise($_GET['sort']);
    }

    // Filter accommodations
    $filteredAccommodations = [];
    foreach ($allAccommodations as $acc) {
        $nameMatch = empty($searchQuery) || stripos($acc['Name'], $searchQuery) !== false;
        $typeMatch = empty($selectedType) || strcasecmp($acc['Type'], $selectedType) === 0;
        $priceMatch = $acc['Price_PN'] >= $minPrice && $acc['Price_PN'] <= $maxPrice;

        if ($nameMatch && $typeMatch && $priceMatch) {
            $filteredAccommodations[] = $acc;
        }
    }

    $allDestinations = getAllDestinations($conn);

    $countries = [];
    foreach($allDestinations as $dest){
        if(!in_array($dest['Country'], $countries)){
            $countries[] = $dest['Country'];
        }
    }
    sort($countries);

    // Sort accommodations
    usort($filteredAccommodations, function ($a, $b) use ($sortBy) {
        switch ($sortBy) {
            case 'price_asc':
                return $a['Price_PN'] <=> $b['Price_PN'];
            case 'price_desc':
                return $b['Price_PN'] <=> $a['Price_PN'];
            default:
                return 0;
        }
    });

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Accommodations - Tripistry</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/accommodations.css">

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
            <li><a href="accommodations.php" class="active-link">Accommodations</a></li>
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
            <div class="topbar-spacer"></div>
            <div class="profile">
                Welcome, <?php echo htmlspecialchars($userName); ?>
                <a href="../logout.php" class="logout-link">Logout</a>
            </div>
        </div>

        <!-- ACCOMMODATIONS PAGE CONTENT -->
        <div class="accommodations-page">

            <div class="accommodations-header">
                <h1>Browse Accommodations</h1>
            </div>

            <!-- FILTERS -->
            <div class="filter-section">
                <form method="GET" class="filter-form">
                    <div class="filter-group">
                        <label for="search">Search Accommodation</label>
                        <input type="text" id="search" name="search" placeholder="Search"
                            value="<?php echo htmlspecialchars($searchQuery); ?>">
                    </div>

                    <div class="filter-group">
                        <label for="country">Filter by Country</label>
                        <select id="country" name="country">
                            <option value="">All Countries</option>
                            <?php foreach ($countries as $country): ?>
                                <option value="<?php echo htmlspecialchars($country); ?>" <?php if ($selectedCountry === $country) { echo 'selected'; } ?>>
                                    <?php echo htmlspecialchars($country); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="type">Accommodation Type</label>
                        <select id="type" name="type">
                            <option value="">All Types</option>
                            <?php foreach ($types as $type): ?>
                                <option value="<?php echo htmlspecialchars($type); ?>" <?php if ($selectedType === $type) { echo 'selected'; } ?> >
                                    <?php echo htmlspecialchars($type); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label>Price Range (per night)</label>
                        <div class="price-range">
                            <input type="number" name="minPrice" placeholder="Min"
                                value="<?php if ($minPrice == 0) { echo ''; } else { echo $minPrice; } ?>">
                            <input type="number" name="maxPrice" placeholder="Max"
                                value="<?php if ($maxPrice == 999999) { echo ''; } else { echo $maxPrice; } ?>">
                        </div>
                    </div>

                    <div class="sort-group">
                        <label for="sort">Sort By Price</label>
                        <select id="sort" name="sort">
                            <option value="price_asc" <?php if ($sortBy === 'price_asc') { echo 'selected'; } ?>>Low to High</option>
                            <option value="price_desc" <?php if ($sortBy === 'price_desc') { echo 'selected'; } ?>>High to Low</option>
                        </select>
                    </div>

                    <div class="filter-buttons">
                        <button type="submit">Apply Filters</button>
                        <a href="accommodations.php" class="reset">Reset</a>
                    </div>
                </form>
            </div>

            <!-- ACCOMMODATIONS GRID -->
            <?php if (empty($filteredAccommodations)): ?>
                <div class="empty-state">
                    <h2>No accommodations found</h2>
                    <p>Try adjusting your search or filters</p>
                    <a href="accommodations.php">View all accommodations</a>
                </div>
            <?php else: ?>
                <?php $accCount = count($filteredAccommodations); ?>
                <div class="accommodations-count">
                    Showing <?php echo $accCount; ?> accommodation<?php if ($accCount !== 1) { echo 's'; } ?>
                </div>

                <div class="accommodations-grid">
                    <?php foreach ($filteredAccommodations as $acc): ?>
                        <div class="accommodation-card">
                            <div class="accommodation-card-image">
                                <?php if ($acc['Image']): ?>
                                    <img src="<?php echo htmlspecialchars($acc['Image']); ?>" alt="<?php echo htmlspecialchars($acc['Name']); ?>">
                                <?php else: ?>
                                    <div class="no-image">No Image</div>
                                <?php endif; ?>
                            </div>

                            <div class="accommodation-card-content">
                                <h3><?php echo htmlspecialchars($acc['Name']); ?></h3>

                                <span class="accommodation-type">
                                    <?php echo htmlspecialchars($acc['Type']); ?>
                                </span>

                                <div class="accommodation-price">
                                    R<?php echo number_format($acc['Price_PN'], 2); ?>
                                    <span class="accommodation-price-label">per night</span>
                                </div>
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
