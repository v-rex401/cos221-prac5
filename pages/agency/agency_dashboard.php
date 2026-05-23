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
    $packages = getAgencyPackages($conn, 3);

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
        <p>you are now in agency_dashboard</p>
        <div class="myContainer"> 
        <div class="sidepanel"> 
            <h1>Welcome</h1> 
            <a href="../logout.php">Logout</a>
         </div> 
         <div id="mainBoard"> 
        
           <button onclick="window.location.href='create_package.php'">Create Package</button> 
           
         </div> 
        
</div> 
        <script src = "../../js/agencyDashboard.js"></script> 
    </body>
</html>
