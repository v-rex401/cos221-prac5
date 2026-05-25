<?php
    //u24611400 Anke de Frey

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/validation.php';
    require_once __DIR__ . '/../../includes/traveller_dashboard_queries.php';
    require_once __DIR__ . '/../../includes/group_join_confirmation_queries.php';

    redirectIfNotTraveller();

    $userID = getCurrentUserID();
    $userResult = getTravellerByUserID($userID);

    if($userResult['success']){
        $userName = sanitise($userResult['user']['Name']);
    }else{
        $userName = 'Traveller';
    }

    // Get group ID from URL
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: traveller_dashboard.php');
        exit;
    }

    $groupId = (int)$_GET['id'];

    // Get group details (group_join_confirmation_queries.php)
    $group = getGroupConfirmation($conn, $groupId);

    if (!$group) {
        header('Location: traveller_dashboard.php');
        exit;
    }

    // Get participant count from Guest_Count
    $participantCount = $group['Guest_Count'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joined Group - Tripistry</title>
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        .container {
            display: flex;
            height: 100vh;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
        }

        .topbar {
            background: white;
            padding: 15px 30px;
            border-bottom: 1px solid #f0f0f0;
        }

        .content-wrapper {
            padding: 50px 30px;
            max-width: 600px;
            margin: 0 auto;
        }

        .confirmation-card {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .success-icon {
            display: inline-block;
            width: 70px;
            height: 70px;
            background: #22c55e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
            margin-bottom: 20px;
        }

        .confirmation-title {
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .confirmation-text {
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .group-info {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 6px;
            margin: 30px 0;
            text-align: left;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #666;
            font-weight: 500;
        }

        .info-value {
            color: #333;
            font-weight: 600;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: #1e73ff;
            color: white;
        }

        .btn-primary:hover {
            background: #1560dd;
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
            border: 1px solid #ddd;
        }

        .btn-secondary:hover {
            background: #e8e8e8;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logout-link {
            color: #1e73ff;
            text-decoration: none;
            font-size: 13px;
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .logout-link:hover {
            background: #f0f7ff;
        }
    </style>
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
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div></div>
                <div class="profile">
                    Welcome, <?php echo htmlspecialchars($userName); ?>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content-wrapper">
            <div class="confirmation-card">
                <div class="success-icon">✓</div>
                <h1 class="confirmation-title">Successfully Joined!</h1>
                <p class="confirmation-text">
                    You've joined a private group booking!<br>
                    Get ready for an amazing group trip!
                </p>

                <div class="group-info">
                    <div class="info-row">
                        <span class="info-label">Sharing Code</span>
                        <span class="info-value"><?php echo htmlspecialchars($group['Sharing_Code']); ?></span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Package</span>
                        <span class="info-value"><?php echo htmlspecialchars($group['package_name']); ?></span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Duration</span>
                        <span class="info-value"><?php echo $group['Duration']; ?> days</span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Group Members</span>
                        <span class="info-value"><?php echo $participantCount; ?>/<?php echo $group['Guest_Limit']; ?></span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Price per Person</span>
                        <span class="info-value">R<?php echo number_format($group['full_price'], 2); ?></span>
                    </div>
                </div>

                <div class="button-group">
                    <a href="bookings.php" class="btn btn-primary">View My Bookings</a>
                    <a href="traveller_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>
