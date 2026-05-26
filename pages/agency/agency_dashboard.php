<?php
//view the packages
//basically the same as the traveller side but just without the option to book a package
//use same filtering system as traveller

require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/validation.php';
require_once __DIR__ . '/../../includes/agency_dashboard_queries.php';

//check access
redirectIfNotAgency();
$agency_id = getCurrentUserID();
$packages = getAgencyPackages($conn, $agency_id);

//auth.php - get the agency's name for the greeting
$agencyResult = getAgencyByUserID($agency_id);
if ($agencyResult['success']) {
    $agencyName = $agencyResult['user']['Name'];
} else {
    $agencyName = 'Agency';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script>
        const AGENCY_ID = <?php echo json_encode($agency_id) ?>
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Dashboard</title>
    <!-- TODO: Change css file to use percentages insteea of pixels -->
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>

<body>
    <div class="myContainer">
        <div class="sidepanel">
            <h1>Welcome to Tripistry </h1>
            <h4> <?php echo htmlspecialchars($agencyName); ?> </h4>
            <hr>
            <a href="manage_group_bookings.php" class="menu">Manage Group Bookings</a>
            <hr>
            <a href="agency_analytics.php" class="menu">Analytics</a>
            <hr>
            <a href="agency_analytics.php" class="menu">My Details</a>
            <hr>
            <a href="agency_analytics.php" class="menu">Currency Converter</a>
            <a href="../logout.php" class="logout-btn">Logout</a>
        </div>


        <div id="mainBoard">

            <button onclick="window.location.href='create_package.php'">Create Package</button>

            <div style="width: 100%;">
                <h3> Your Packages </h3>
            </div>

            <?php if (empty($packages)): ?>
                <p> No packages yet. Create one!</p>
            <?php else: ?>
                <?php foreach ($packages as $pkg): ?>
                    <div class="dashboardCard">
                        <h3> <?php echo htmlspecialchars($pkg['Name']) ?> </h3>
                        <p><strong>Price:</strong> R <?php echo htmlspecialchars($pkg['Price']) ?> </p>
                        <p><strong>Duration</strong> <?php echo htmlspecialchars($pkg['Duration']) ?> days </p>
                        <p><strong>Description</strong> <?php echo htmlspecialchars($pkg['Description']) ?></p>
                        <button onclick="window.location.href='edit_package.php?package_id=<?php echo $pkg['Package_ID'] ?>' ">Edit</button>
                        <button onclick="deletePackage(<?php echo $pkg['Package_ID'] ?>)">Delete</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

    </div>
    <script src="../../js/agencyDashboard.js"></script>
</body>

</html>