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
                <a href="#booking" class="btn btn-primary">Book Now</a>
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

    </div>

</div>

</body>
</html>
