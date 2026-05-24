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
    if($userResult['success']){
        $userName = sanitise($userResult['user']['Name']);
    }else{
        $userName = 'Traveller';
    }

    //includes/traveller_dashboard_queries.php
    //top rated package for column 3 default view
    $topRatedPackages = getTopRatedPackages($conn, 1);

    //get filtering parameters
    //destinations
    if(isset($_GET['destinations'])){
        $destination = (int)$_GET['destination'];
    }else{
        $destination = null;
    }

    //get package based on filters
    if($destination){
        $packages = getPackagesByDestination($conn, $destination);
    }else{
        $packages = getAllPackages($conn);
    }

    //price range
    if(isset($_GET['minPrice'])){
        $minPrice = (float)$_GET['minPrice'];
    }else{
        $minPrice = 0;
    }

    if(isset($_GET['maxPrice'])){
        $maxPrice = (float)$_GET['maxPrice'];
    }else{
        $maxPrice = 999999;
    }

    //apply price filter
    $filteredPackages = [];
    foreach($packages as $package){
        if($package['Price'] >= $minPrice && $package['Price'] <= $maxPrice){
            $filteredPackages[] = $package;
        }
    }
    $packages = $filteredPackages;

    //duration
    if(isset($_GET['minDuration'])){
        $minDuration = (int)$_GET['minDuration'];
    }else{
        $minDuration = 1;
    }

    if(isset($_GET['maxDuration'])){
        $maxDuration = (int)$_GET['maxDuration'];
    }else{
        $maxDuration = 365;
    }

    //apply duration filter
    $filteredPackages = [];
    foreach($packages as $package){
        if($package['Duration'] >= $minDuration && $package['Duration'] <= $maxDuration){
            $filteredPackages[] = $package;
        }
    }
    $packages = $filteredPackages;


    //rating
    if(isset($_GET['minRating'])){
        $minRating = (float)$_GET['minRating'];
    }else{
        $minRating = 0;
    }

    //apply rating filter
    $filteredPackages = [];
    foreach($packages as $package){
        if($package['avg_rating'] >= $minRating){
            $filteredPackages[] = $package;
        }
    }
    $packages = $filteredPackages;

    //includes

    //sortby
    if(isset($_GET['sortBy'])){
        $sortBy = sanitise($_GET['sortBy']);
    }else{
        $sortBy = 'popular';
    }

    //search query
    if(isset($_GET['search'])){
        $searchQuery = sanitise($_GET['search']);
    }else{
        $searchQuery = '';
    }

    //apply search filter
    if($searchQuery){
        $filteredPackages = [];
        foreach($packages as $package){
            $packageNameMatch = stripos($package['package_name'], $searchQuery) !== false;
            $agencyNameMatch = stripos($package['agency_name'], $searchQuery) !== false;
            
            if($packageNameMatch || $agencyNameMatch){
                $filteredPackages[] = $package;
            }
        }
        $packages = $filteredPackages;
    }

    // Handle package view parameter
    $selectedPackage = null;

    if (isset($_GET['view'])) {
        // A package was clicked - show that package
        $viewPackageId = (int)$_GET['view'];
        $selectedPackage = getPackageDetails($conn, $viewPackageId);
    } elseif (!empty($topRatedPackages)) {
        // default to the top rated package
        $selectedPackage = getPackageDetails($conn, $topRatedPackages[0]['Package_ID']);
    } elseif (!empty($packages)) {
        // Fallback to first package if no rated packages exist
        $selectedPackage = getPackageDetails($conn, $packages[0]['Package_ID']);
    }

    //all destinations for filter dropdown
    $allDestinations = getAllDestinations($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tripistry Travel Booking</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/tinyview.css">

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
            <li><a href="bookings.php">Bookings</a></li>
            <li><a href="reviews.php">Reviews</a></li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- Search bar that will be carried over when click on sidebar for destinations, accomodations, attractions, restaurants and packages -->
        <div class="topbar">
            <div class="search-bar">
                <form method="GET">
                    <input type="text" name="search" placeholder="Search"
                        value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <button type="submit">Search</button>
                </form>
            </div>

            <div class="profile">
                Welcome, <?php echo htmlspecialchars($userName); ?>
                <a href="../logout.php" class="logout-link">Logout</a>
            </div>
        </div>

        <!-- FILTER BAR -->
        <div class="filters filters-bar">
                <h3>Filter Packages</h3>

                <form method="GET" id="filterForm">
                    <!-- Search (hidden in form) -->
                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($searchQuery); ?>">

                    <!-- Destination Filter -->
                    <div class="filter-group">
                        <label>Destination</label>
                        <select name="destination">
                            <option value="">All Destinations</option>
                            <?php foreach ($allDestinations as $dest): ?>
                                <?php
                                    if($destination == $dest['Destination_ID']){
                                        $isSelected = 'selected';
                                    }else{
                                        $isSelected = '';
                                    }
                                ?>
                                <option value="<?php echo $dest['Destination_ID']; ?>" <?php echo $isSelected; ?>>
                                    <?php echo htmlspecialchars($dest['Name']); ?> (<?php echo htmlspecialchars($dest['Country']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="filter-group">
                        <label>Price Range</label>
                        <div>
                            <?php
                                if($minPrice == 0){
                                    $minPriceDisplay = '';
                                }else{
                                    $minPriceDisplay = $minPrice;
                                }
                                if($maxPrice == 999999){
                                    $maxPriceDisplay = '';
                                }else{
                                    $maxPriceDisplay = $maxPrice;
                                }
                            ?>
                            <input type="number" name="minPrice" placeholder="Min" value="<?php echo $minPriceDisplay; ?>">
                            <input type="number" name="maxPrice" placeholder="Max" value="<?php echo $maxPriceDisplay; ?>" >
                        </div>
                    </div>

                    <!-- Duration Filter -->
                    <div class="filter-group">
                        <label>Duration (Days)</label>
                        <div>
                            <?php
                                if($minDuration == 1){
                                    $minDurationDisplay = '';
                                }else{
                                    $minDurationDisplay = $minDuration;
                                }
                                if($maxDuration == 365){
                                    $maxDurationDisplay = '';
                                }else{
                                    $maxDurationDisplay = $maxDuration;
                                }
                            ?>
                            <input type="number" name="minDuration" placeholder="Min" value="<?php echo $minDurationDisplay; ?>">
                            <input type="number" name="maxDuration" placeholder="Max" value="<?php echo $maxDurationDisplay; ?>">
                        </div>
                    </div>

                    <!-- Rating Filter -->
                    <div class="filter-group">
                        <label>Rating</label>
                        <select name="minRating">
                            <?php
                                if($minRating == 0){
                                    echo '<option value="0" selected>All Ratings</option>';
                                }else{
                                    echo '<option value="0">All Ratings</option>';
                                }
                                if($minRating == 3){
                                    echo '<option value="3" selected>3+ Stars</option>';
                                }else{
                                    echo '<option value="3">3+ Stars</option>';
                                }
                                if($minRating == 4){
                                    echo '<option value="4" selected>4+ Stars</option>';
                                }else{
                                    echo '<option value="4">4+ Stars</option>';
                                }
                                if($minRating == 5){
                                    echo '<option value="5" selected>5 Stars</option>';
                                }else{
                                    echo '<option value="5">5 Stars</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <button type="submit">Apply Filters</button>
                    <a href="traveller_dashboard.php" class="reset-link">Reset</a>
                </form>
        </div>

        <!-- 2-column grid : packages, details(mini view for package) -->
        <div class="content">

            <!-- COLUMN 1: PACKAGES -->
            <div class="packages">
                <h2 class="section-heading">Packages</h2>
                <div class="packages-header">
                    <a href="create_private_group.php" class="create-group-btn">Create Private Group</a>

                    <form method="GET">
                        <!-- Preserve other filters -->
                        <?php
                            if($destination){
                                echo '<input type="hidden" name="destination" value="' . htmlspecialchars($destination) . '">';
                            }
                            if($minPrice != 0){
                                echo '<input type="hidden" name="minPrice" value="' . $minPrice . '">';
                            }
                            if($maxPrice != 999999){
                                echo '<input type="hidden" name="maxPrice" value="' . $maxPrice . '">';
                            }
                            if($minDuration != 1){
                                echo '<input type="hidden" name="minDuration" value="' . $minDuration . '">';
                            }
                            if($maxDuration != 365){
                                echo '<input type="hidden" name="maxDuration" value="' . $maxDuration . '">';
                            }
                            if($minRating != 0){
                                echo '<input type="hidden" name="minRating" value="' . $minRating . '">';
                            }
                            echo '<input type="hidden" name="search" value="' . htmlspecialchars($searchQuery) . '">';
                        ?>

                        <select name="sortBy" onchange="this.form.submit();">
                            <?php
                                if($sortBy == 'price_low'){
                                    echo '<option value="price_low" selected>Sort: Price (Low to High)</option>';
                                }else{
                                    echo '<option value="price_low">Sort: Price (Low to High)</option>';
                                }
                                if($sortBy == 'price_high'){
                                    echo '<option value="price_high" selected>Sort: Price (High to Low)</option>';
                                }else{
                                    echo '<option value="price_high">Sort: Price (High to Low)</option>';
                                }
                                if($sortBy == 'rating'){
                                    echo '<option value="rating" selected>Sort: Rating</option>';
                                }else{
                                    echo '<option value="rating">Sort: Rating</option>';
                                }
                                if($sortBy == 'duration'){
                                    echo '<option value="duration" selected>Sort: Duration</option>';
                                }else{
                                    echo '<option value="duration">Sort: Duration</option>';
                                }
                            ?>
                        </select>
                    </form>
                </div>

                <!-- Packages List -->
                <?php if (empty($packages)): ?>
                    <div class="empty-state">
                        <p>No packages found matching your filters.</p>
                        <a href="traveller_dashboard.php">Clear filters</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($packages as $package): ?>
                        <div class="package-card"
                            onclick="togglePackageSelection(<?php echo $package['Package_ID']; ?>, event)"
                            data-package-id="<?php echo $package['Package_ID']; ?>">

                            <!-- Duration Badge -->
                            <div class="package-duration-badge">
                                <?php echo $package['Duration']; ?> days
                            </div>

                            <!-- Image -->
                            <div class="package-card-image">
                                <?php if (isset($package['Image_URL']) && $package['Image_URL']): ?>
                                    <img src="<?php echo htmlspecialchars($package['Image_URL']); ?>"
                                        alt="<?php echo htmlspecialchars($package['package_name']); ?>">
                                <?php else: ?>
                                    <div class="no-image">No Image</div>
                                <?php endif; ?>
                            </div>

                            <!-- Package Info -->
                            <div class="package-info">
                                <div>
                                    <h3><?php echo htmlspecialchars($package['package_name']); ?></h3>
                                    <p>
                                        <?php echo htmlspecialchars($package['agency_name']); ?>
                                        <?php echo $package['Duration']; ?> Days
                                    </p>

                                    <div class="package-meta">
                                        <div class="package-meta-left">
                                            <span class="package-rating">
                                                <?php echo generateStarRating($package['avg_rating']); ?>
                                            </span>
                                            <span class="package-rating-value"><?php echo number_format($package['avg_rating'], 1); ?></span>
                                            <span class="package-review-count">(<?php echo $package['review_count']; ?> reviews)</span>
                                        </div>

                                        <div class="package-price">R<?php echo number_format($package['Price'], 2); ?></div>
                                    </div>
                                </div>

                                <!-- Inclusion indicators -->
                                <div class="details-pills">
                                    <?php if (packageHasFlights($conn, $package['Package_ID'])): ?>
                                        <span class="details-pill">Flights</span>
                                    <?php endif; ?>
                                    <?php if (packageHasAccommodations($conn, $package['Package_ID'])): ?>
                                        <span class="details-pill">Hotel</span>
                                    <?php endif; ?>
                                    <?php if (packageHasRestaurants($conn, $package['Package_ID'])): ?>
                                        <span class="details-pill">Meals</span>
                                    <?php endif; ?>
                                    <?php if (packageHasAttractions($conn, $package['Package_ID'])): ?>
                                        <span class="details-pill">Tours</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- COLUMN 2: PACKAGE DETAILS -->
            <div class="details-section">
                <!-- Initially shows top rated package and when package clicked show a mini preview of that package -->
                <?php if (isset($_GET['view'])): ?>
                    <h2 class="details-heading">Package Details</h2>
                <?php else: ?>
                    <h2 class="details-heading">Highest Rated Package</h2>
                <?php endif; ?>

                <!-- Single Package Details View -->
                <?php if ($selectedPackage): ?>
                    <!-- Hero Section -->
                    <div class="details-hero">
                        <?php if (!empty($selectedPackage['images'])): ?>
                            <img src="<?php echo htmlspecialchars($selectedPackage['images'][0]['Image_URL']); ?>" alt="<?php echo htmlspecialchars($selectedPackage['package_name']); ?>">
                        <?php else: ?>
                            <div class="no-image">No Image</div>
                        <?php endif; ?>

                        <div class="details-badge">
                            <?php echo $selectedPackage['Duration']; ?> days
                        </div>

                        <div class="details-title-overlay">
                            <h2><?php echo htmlspecialchars($selectedPackage['package_name']); ?></h2>
                            <p class="agency-name"><?php echo htmlspecialchars($selectedPackage['agency_name']); ?></p>
                        </div>
                    </div>

                    <div class="details-body">
                        <!-- Inclusions -->
                        <div class="details-pills">
                            <?php if (!empty($selectedPackage['flights'])): ?>
                                <span class="details-pill">Flights</span>
                            <?php endif; ?>
                            <?php if (!empty($selectedPackage['accommodations'])): ?>
                                <span class="details-pill">Hotel</span>
                            <?php endif; ?>
                            <?php if (!empty($selectedPackage['restaurants'])): ?>
                                <span class="details-pill">Meals</span>
                            <?php endif; ?>
                            <?php if (!empty($selectedPackage['attractions'])): ?>
                                <span class="details-pill">Tours</span>
                            <?php endif; ?>
                        </div>

                        <!-- Price & Rating -->
                        <div class="details-price-row">
                            <div>
                                <div class="details-price">
                                    R<?php echo number_format($selectedPackage['Price'], 2); ?>
                                    <br>
                                    <span class="per-person">per person</span>
                                </div>
                            </div>

                            <div class="details-rating">
                                <div>
                                    <?php echo generateStarRating($selectedPackage['avg_rating']); ?>
                                </div>
                                <strong><?php echo number_format($selectedPackage['avg_rating'], 1); ?></strong>
                                <span class="details-rating-count">(<?php echo $selectedPackage['review_count']; ?> reviews)</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <div class="details-label">About this package</div>
                            <p class="details-desc">
                                <?php echo htmlspecialchars($selectedPackage['Description']); ?>
                            </p>
                        </div>

                        <!-- Destinations -->
                        <?php if (!empty($selectedPackage['destinations'])): ?>
                            <div>
                                <div class="details-label">Destinations</div>
                                <div class="destinations-list">
                                    <?php foreach ($selectedPackage['destinations'] as $dest): ?>
                                        <div class="destination-item">
                                            <?php echo htmlspecialchars($dest['Name']); ?>, <?php echo htmlspecialchars($dest['Country']); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <br>

                        <!-- Buttons -->
                        <div class="details-buttons">
                            <button type="button" class="view-btn" onclick="window.location.href='package_details.php?id=<?php echo $selectedPackage['Package_ID']; ?>'">View Details</button>
                            <button type="button" class="book-btn">Book Now</button>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="detail-placeholder">
                        <p>Select a package to view details</p>
                    </div>
                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

</body>
</html>

<script src="../../js/package_traveller_dashboard.js"></script>
