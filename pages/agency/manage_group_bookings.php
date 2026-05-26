<?php
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/validation.php';
require_once __DIR__ . '/../../includes/agency_dashboard_queries.php';
require_once __DIR__ . '/../../includes/manage_group_bookings_queries.php';


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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Dashboard</title>
    <!-- TODO: Change css file to use percentages insteea of pixels -->
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>

<body>
    <div id="mainBoard">
        <a href="agency_dashboard.php">Go Back</a>
        <?php if (empty($packages)): ?>
            <p> No Group Packages Yet!</p>
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
</body>

</html>