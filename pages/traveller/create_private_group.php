<?php
    //u24611400 Anke de Frey

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/traveller_dashboard_queries.php';
    require_once __DIR__ . '/../../includes/create_private_group_queries.php';

    redirectIfNotTraveller();

    $userID = getCurrentUserID();
    $userResult = getTravellerByUserID($userID);

    if($userResult['success']){
        $userName = sanitise($userResult['user']['Name']);
    }else{
        $userName = 'Traveller';
    }

    // Handle form submission
    $createdGroup = null;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['package_id'])) {
            $packageId = (int)$_POST['package_id'];
        } else {
            $packageId = null;
        }

        if (isset($_POST['max_participants'])) {
            $guestLimit = (int)$_POST['max_participants'];
        } else {
            $guestLimit = 10;
        }

        if (isset($_POST['group_name'])) {
            $groupName = sanitise($_POST['group_name']);
        } else {
            $groupName = '';
        }

        if (isset($_POST['start_date'])) {
            $startDate = sanitise($_POST['start_date']);
        } else {
            $startDate = date('Y-m-d');
        }

        if ($packageId && $groupName && $guestLimit > 0 && $guestLimit <= 50) {
            $package = getPackageDetails($conn, $packageId);
            if ($package) {
                $bookingDate = date('Y-m-d');
                $endDate = date('Y-m-d', strtotime($startDate . ' + ' . (int)$package['Duration'] . ' days'));
                $agencyId = (int)$package['Agency_ID'];

                // Create the group booking (create_private_group_queries.php)
                $bookingId = createGroupBooking($conn, $packageId, $bookingDate, $startDate, $endDate, $guestLimit, $agencyId);

                if ($bookingId) {
                    $createdGroup = [
                        'id' => $bookingId,
                        'name' => $groupName,
                        'code' => (string)$bookingId,
                        'package' => $package['package_name'],
                        'max' => $guestLimit
                    ];
                }
            }
        }
    }

    // Get all packages for dropdown
    $packages = getAllPackages($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Private Group - Tripistry</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/create_private_group.css">
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
            <li><a href="reviews.php">Reviews</a></li>
        </ul>

        <a href="../logout.php" class="sidebar-logout">Logout</a>
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
            </div>
        </div>

        <!-- PAGE HEADER -->
        <div class="page-header">
            <a href="traveller_dashboard.php" class="back-link">Back</a>
            <h1>Create Private Group</h1>
            <p class="page-header-description">Invite your friends to a shared package booking</p>
        </div>

        <!-- CONTENT -->
        <div class="content-wrapper">
            <div class="two-column">
                <!-- Form -->
                <div class="form-card">
                    <h2>New Private Group</h2>

                    <?php if ($createdGroup): ?>
                        <div class="success-notice">
                            Private group created successfully!
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="create-group-form">
                        <div class="form-group">
                            <label for="package_id">Select Package *</label>
                            <select id="package_id" name="package_id" required>
                                <option value="">Choose a package...</option>
                                <?php foreach ($packages as $pkg): ?>
                                    <option value="<?php echo $pkg['Package_ID']; ?>">
                                        <?php echo htmlspecialchars($pkg['package_name']); ?> - R<?php echo number_format($pkg['Price'], 2); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="group_name">Group Name *</label>
                            <input type="text" id="group_name" name="group_name" placeholder="group name" required>
                        </div>

                        <div class="form-group">
                            <label for="start_date">Travel Start Date *</label>
                            <input type="date" id="start_date" name="start_date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="max_participants">Max Participants (2-50) *</label>
                            <input type="number" id="max_participants" name="max_participants" min="2" max="50" value="10" required>
                        </div>

                        <button type="submit" class="submit-btn">Create Private Group</button>
                    </form>
                </div>

                <!-- Success Message -->
                <?php if ($createdGroup): ?>
                    <div class="success-card">
                        <div class="success-title">Group Created</div>
                        <div class="success-text">
                            <strong><?php echo htmlspecialchars($createdGroup['name']); ?></strong><br>
                            Package: <?php echo htmlspecialchars($createdGroup['package']); ?><br>
                            Max: <?php echo $createdGroup['max']; ?> participants
                        </div>

                        <div class="share-code-box">
                            <div class="code-label">Share This Code</div>
                            <div class="share-code"><?php echo $createdGroup['code']; ?></div>
                        </div>

                        <div class="share-url">
                            Share this link:<br>
                            <strong><?php echo htmlspecialchars($_SERVER['HTTP_HOST']); ?>/cos221-prac5/pages/traveller/join_group.php?code=<?php echo $createdGroup['code']; ?></strong>
                        </div>

                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

</div>


</body>
</html>
