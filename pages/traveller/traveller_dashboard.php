<?php
    //u24611400 Anke de Frey

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/dashboard_queries.php';

    //session.php
    redirectIfNotTraveller();

    //session.php
    $userID = getCurrentUserID();

    //auth.php
    $userResult = getTravellerByUserID($userID);
    
    //validation.php
    $userName = $userResult['success'] ? sanitise($userResult['user']['Name']) : 'Traveller';

    //includes/dashboard_queries.php
    $topRatedPackage= getTopRatedPackages($conn, 4);

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

    // Get first package to display in details panel
    $selectedPackage = null;
    if (!empty($packages)) {
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
</head>

<body>

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo">Tripistry</div>

        <ul>
            <li><a href="traveller_dashboard.php">Home</a></li>
            <li><a href="#destinations" class="sidebar-link">Destinations</a></li>
            <li><a href="#flights">Flights</a></li>
            <li><a href="#accommodations">Accommodations</a></li>
            <li><a href="#attractions">Attractions</a></li>
            <li><a href="#restaurants">Restaurants</a></li>
            <li><a href="#packages">Packages</a></li>
            <li><a href="#bookings">Bookings</a></li>
            <li><a href="#reviews">Reviews</a></li>
        </ul>

        <!--Add styling to this button-->
        <a href="logout.php">Logout</a>
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
            </div>
        </div>

        <!-- 3-column grid : filters, packages, details(mini view for package) -->
        <div class="content">

            <!--COL 1 FILTERS -->
            <div class="filters">
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
                                <option value="<?php echo $dest['Destination_ID']; ?>" <?php echo $destination == $dest['Destination_ID'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($dest['Name']); ?> (<?php echo htmlspecialchars($dest['Country']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="filter-group">
                        <label>Price Range</label>
                        <div>
                            <input type="number" name="minPrice" placeholder="Min" value="<?php echo $minPrice == 0 ? '' : $minPrice; ?>">
                            <input type="number" name="maxPrice" placeholder="Max" value="<?php echo $maxPrice == 999999 ? '' : $maxPrice; ?>" >
                        </div>
                    </div>

                    <!-- Duration Filter -->
                    <div class="filter-group">
                        <label>Duration (Days)</label>
                        <div>
                            <input type="number" name="minDuration" placeholder="Min" value="<?php echo $minDuration == 1 ? '' : $minDuration; ?>">
                            <input type="number" name="maxDuration" placeholder="Max" value="<?php echo $maxDuration == 365 ? '' : $maxDuration; ?>">
                        </div>
                    </div>

                    <!-- Rating Filter -->
                    <div class="filter-group">
                        <label>Rating</label>
                        <select name="minRating">
                            <option value="0" <?php echo $minRating == 0 ? 'selected' : ''; ?>>All Ratings</option>
                            <option value="3" <?php echo $minRating == 3 ? 'selected' : ''; ?>>3+ Stars</option>
                            <option value="4" <?php echo $minRating == 4 ? 'selected' : ''; ?>>4+ Stars</option>
                            <option value="5" <?php echo $minRating == 5 ? 'selected' : ''; ?>>5 Stars</option>
                        </select>
                    </div>

                    <button type="submit">Apply Filters</button>
                    <a href="traveller_dashboard.php">Reset</a>
                </form>
            </div>

            <!-- COLUMN 2: PACKAGES -->
            <div class="packages">
                <div class="packages-header">
                    <h2>Available Travel Packages (<?php echo count($packages); ?>)</h2>

                    <form method="GET">
                        <!-- Preserve other filters -->
                        <input type="hidden" name="destination" value="
                            <?php echo htmlspecialchars($destination); ?>">
                        <input type="hidden" name="minPrice" value="
                            <?php echo $minPrice == 0 ? '' : $minPrice; ?>">
                        <input type="hidden" name="maxPrice" value="
                            <?php echo $maxPrice == 999999 ? '' : $maxPrice; ?>">
                        <input type="hidden" name="minDuration" value="
                            <?php echo $minDuration == 1 ? '' : $minDuration; ?>">
                        <input type="hidden" name="maxDuration" value="
                            <?php echo $maxDuration == 365 ? '' : $maxDuration; ?>">
                        <input type="hidden" name="minRating" value="
                            <?php echo $minRating; ?>">
                        <input type="hidden" name="search" value="
                            <?php echo htmlspecialchars($searchQuery); ?>">

                        <select name="sortBy" onchange="this.form.submit();">
                            <option value="popular"
                                <?php echo $sortBy == 'popular' ? 'selected' : ''; ?>>Sort: Most Popular</option>
                            <option value="price_low"
                                <?php echo $sortBy == 'price_low' ? 'selected' : ''; ?>>Sort: Price (Low to High)</option>
                            <option value="price_high"
                                <?php echo $sortBy == 'price_high' ? 'selected' : ''; ?>>Sort: Price (High to Low)</option>
                            <option value="rating"
                                <?php echo $sortBy == 'rating' ? 'selected' : ''; ?>>Sort: Rating</option>
                            <option value="duration"
                                <?php echo $sortBy == 'duration' ? 'selected' : ''; ?>>Sort: Duration</option>
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
                        <div class="package-card" onclick="location.href='?<?php echo http_build_query(array_merge($_GET, ['selected_id' => $package['Package_ID']])); ?>'">
                            <!-- Image -->
                            <div class="package-card-image">
                                <?php if ($package['image_url']): ?>
                                    <img src="<?php echo htmlspecialchars($package['image_url']); ?>" alt="<?php echo htmlspecialchars($package['package_name']); ?>">
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
                                        <span class="details-pill">✈ Flights</span>
                                    <?php endif; ?>
                                    <?php if (packageHasAccommodations($conn, $package['Package_ID'])): ?>
                                        <span class="details-pill">🏨 Hotel</span>
                                    <?php endif; ?>
                                    <?php if (packageHasRestaurants($conn, $package['Package_ID'])): ?>
                                        <span class="details-pill">🍽 Meals</span>
                                    <?php endif; ?>
                                    <?php if (packageHasAttractions($conn, $package['Package_ID'])): ?>
                                        <span class="details-pill">🗺 Tours</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- COLUMN 3: PACKAGE DETAILS -->
            <div class="details-section">

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
                                <span class="details-pill">✈ Flights</span>
                            <?php endif; ?>
                            <?php if (!empty($selectedPackage['accommodations'])): ?>
                                <span class="details-pill">🏨 Hotel</span>
                            <?php endif; ?>
                            <?php if (!empty($selectedPackage['restaurants'])): ?>
                                <span class="details-pill">🍽 Meals</span>
                            <?php endif; ?>
                            <?php if (!empty($selectedPackage['attractions'])): ?>
                                <span class="details-pill">🗺 Tours</span>
                            <?php endif; ?>
                        </div>

                        <!-- Price & Rating -->
                        <div class="details-price-row">
                            <div>
                                <div class="details-price">
                                    R<?php echo number_format($selectedPackage['Price'], 2); ?>
                                    <span class="per-person">/ person</span>
                                </div>
                            </div>

                            <div class="details-rating">
                                <div class="details-stars">
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

                        <!-- Buttons -->
                        <div class="details-buttons">
                            <button class="btn btn-secondary">View Details</button>
                            <button class="btn btn-primary">Book Now</button>
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
