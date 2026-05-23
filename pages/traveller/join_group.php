<?php
    //u24611400 Anke de Frey

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/traveller_dashboard_queries.php';
    require_once __DIR__ . '/../../includes/join_group_queries.php';

    redirectIfNotTraveller();

    $userID = getCurrentUserID();
    $userResult = getTravellerByUserID($userID);

    if($userResult['success']){
        $userName = sanitise($userResult['user']['Name']);
    }else{
        $userName = 'Traveller';
    }

    if (isset($_GET['code'])) {
        $sharingCode = sanitise($_GET['code']);
    } else {
        $sharingCode = '';
    }
    $group = null;
    $alreadyJoined = false;
    $groupFull = false;
    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['code'])) {
            $code = sanitise($_POST['code']);
        } else {
            $code = '';
        }

        if ($code) {
            // Find group by code (join_group_queries.php)
            $group = getGroupByCode($conn, $code);

            if ($group) {
                // Check if group is full
                if ($group['Guest_Count'] >= $group['Guest_Limit']) {
                    $groupFull = true;
                } else {
                    // Add this guest to the group (join_group_queries.php)
                    if (addGuestToGroup($conn, $group['Booking_ID'])) {
                        // Redirect to confirmation
                        header('Location: group_join_confirmation.php?id=' . $group['Booking_ID']);
                        exit;
                    } else {
                        $error = "Failed to join group. Please try again.";
                    }
                }
            } else {
                $error = "Invalid code or group is no longer available.";
            }
        }
    } else if ($sharingCode) {
        // Get group from URL code (join_group_queries.php)
        $group = getGroupByCode($conn, $sharingCode);

        if ($group) {
            // Check if full
            $groupFull = ($group['Guest_Count'] >= $group['Guest_Limit']);
        }
    }

    // Get group details with package info
    if ($group) {
        // Get the package for this group (join_group_queries.php)
        $package = getPackageRow($conn, $group['Package_ID']);

        // Get participant count from group_bookings
        $participantCount = $group['Guest_Count'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Private Group - Tripistry</title>
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

        <!-- PAGE HEADER -->
        <div class="page-header">
            <h1>Join Private Group</h1>
            <p>Enter the sharing code to join a friend's group booking</p>
        </div>

        <!-- CONTENT -->
        <div class="content-wrapper">
            <?php if ($error): ?>
                <div class="error-box">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($group): ?>
                <!-- Group Details -->
                <div class="card">
                    <h2 style="margin-top: 0;">Group Details</h2>

                    <div class="group-details">
                        <div class="detail-row">
                            <span class="detail-label">Sharing Code</span>
                            <span class="detail-value"><?php echo htmlspecialchars($group['Sharing_Code']); ?></span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Package</span>
                            <span class="detail-value"><?php echo htmlspecialchars($package['package_name']); ?></span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Package</span>
                            <span class="detail-value">R<?php echo number_format($package['Price'], 2); ?> per person</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Participants</span>
                            <span class="detail-value"><?php echo $participantCount; ?>/<?php echo $group['Guest_Limit']; ?></span>
                        </div>

                        <div>
                            <span class="detail-label" style="display: block; margin-top: 10px;">Availability</span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?php echo ($participantCount / $group['Guest_Limit']) * 100; ?>%"></div>
                            </div>
                        </div>
                    </div>

                    <?php if ($alreadyJoined): ?>
                        <div class="joined-message">
                            You've already joined this group! Check your bookings for details.
                        </div>
                    <?php elseif ($groupFull): ?>
                        <div class="full-message">
                            This group is now full. No more participants can join.
                        </div>
                    <?php else: ?>
                        <form method="POST" class="form-group" style="margin: 0; margin-top: 20px;">
                            <input type="hidden" name="code" value="<?php echo htmlspecialchars($sharingCode); ?>">
                            <button type="submit" class="submit-btn">Join This Group</button>
                        </form>
                    <?php endif; ?>

                    <div class="button-group">
                        <a href="traveller_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                    </div>
                </div>
            <?php else: ?>
                <!-- Code Entry Form -->
                <div class="card">
                    <h2 style="margin-top: 0;">Enter Sharing Code</h2>

                    <form method="POST">
                        <div class="form-group">
                            <label for="code">Sharing Code</label>
                            <input type="text" id="code" name="code" placeholder="code" maxlength="20" autofocus required>
                        </div>

                        <button type="submit" class="submit-btn">Find Group</button>

                        <a href="traveller_dashboard.php" class="btn btn-secondary" style="margin-top: 10px;">Cancel</a>
                    </form>
                </div>
            <?php endif; ?>
        </div>

    </div>

</div>

</body>
</html>
