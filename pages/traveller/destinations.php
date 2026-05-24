<?php
    //u24611400 Anke de Frey

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/traveller_dashboard_queries.php';

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

    // Get all destinations
    $allDestinations = getAllDestinations($conn);

    // Get filter parameters
    $searchQuery = '';
    $selectedCountry = '';

    if(isset($_GET['search'])){
        $searchQuery = sanitise($_GET['search']);
    }

    if(isset($_GET['country'])){
        $selectedCountry = sanitise($_GET['country']);
    }

    // Filter destinations
    $filteredDestinations = [];
    foreach($allDestinations as $dest){
        $nameMatch = empty($searchQuery) || stripos($dest['Name'], $searchQuery) !== false;
        $countryMatch = empty($selectedCountry) || strcasecmp($dest['Country'], $selectedCountry) === 0;

        if($nameMatch && $countryMatch){
            $filteredDestinations[] = $dest;
        }
    }

    // Get unique countries for filter dropdown
    $countries = [];
    foreach($allDestinations as $dest){
        if(!in_array($dest['Country'], $countries)){
            $countries[] = $dest['Country'];
        }
    }
    sort($countries);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Destinations - Tripistry</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/destination.css">
</head>

<body>

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo">Tripistry</div>

        <ul>
            <li><a href="traveller_dashboard.php">Home</a></li>
            <li><a href="destinations.php" class="active-link">Destinations</a></li>
            <li><a href="flights.php">Flights</a></li>
            <li><a href="accommodations.php">Accommodations</a></li>
            <li><a href="attractions.php">Attractions</a></li>
            <li><a href="restaurants.php">Restaurants</a></li>
            <li><a href="packages.php">Packages</a></li>
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
            <div class="profile">
                Welcome, <?php echo htmlspecialchars($userName); ?>
            </div>
        </div>

        <!-- DESTINATIONS PAGE CONTENT -->
        <div class="destination-page">

            <div class="destination-header">
                <h1>Browse Destinations</h1>
            </div>

            <!-- FILTERS -->
            <div class="filter-section">
                <form method="GET" class="destination-form">
                    <div class="filter-group">

                        <label for="search">Search</label>
                        <input type="text" id="search" name="search" placeholder="Destination"
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

                    <div class="filter-buttons">
                        <button type="submit">Apply Filters</button>
                        <a href="destinations.php" class="reset">Reset</a>
                    </div>
                </form>
            </div>

            <!-- DESTINATIONS GRID -->
            <?php if (empty($filteredDestinations)): ?>
                <div class="empty-state">
                    <h2>No destinations found</h2>
                    <p>Try adjusting your search or filters</p>
                    <a href="destinations.php">View all destinations</a>
                </div>
            <?php else: ?>
                <div class="destinations-grid">
                    <?php foreach ($filteredDestinations as $dest):
                        // Count packages for this destination
                        $packageCount = 0;
                        $allPackages = getAllPackages($conn);
                        foreach ($allPackages as $pkg) {
                            $pkgDests = getPackageDestinations($conn, $pkg['Package_ID']);
                            foreach ($pkgDests as $pkgDest) {
                                if ($pkgDest['Destination_ID'] === $dest['Destination_ID']) {
                                    $packageCount++;
                                    break;
                                }
                            }
                        }
                    ?>
                        <a href="traveller_dashboard.php?destination=<?php echo $dest['Destination_ID']; ?>" class="card-link">
                            <div class="destination-card">
                                <div class="destination-card-image">
                                    <?php if ($dest['Image']): ?>
                                        <img src="<?php echo htmlspecialchars($dest['Image']); ?>" alt="<?php echo htmlspecialchars($dest['Name']); ?>">
                                    <?php else: ?>
                                        <div class="no-image">No Image</div>
                                    <?php endif; ?>
                                </div>

                                <div class="destination-card-content">
                                    <h3><?php echo htmlspecialchars($dest['Name']); ?></h3>
                                    <div class="country"><?php echo htmlspecialchars($dest['Country']); ?></div>

                                    <div class="package-count">
                                        <?php echo $packageCount; ?> package<?php if ($packageCount !== 1) { echo 's'; } ?> available
                                    </div>

                                    <div class="view-button">
                                        View Packages
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>

</div>

</body>
</html>
