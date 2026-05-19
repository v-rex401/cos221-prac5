<?php
    //view the packages
    //basically the same as the traveller side but just without the option to book a package
    //use same filtering system as traveller

    require_once __DIR__ . '/../../includes/session.php';
    require_once __DIR__ . '/../../includes/database.php';
    require_once __DIR__ . '/../../includes/auth.php';

    //check access

    //! Removed function to work on front-end of UI 
    //redirectIfNotAgency();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Agency Dashboard</title>
        <link rel="stylesheet" href="../../css/style.css">
        <!-- TODO: Change css file to use percentages insteea of pixels -->
         <link rel="stylesheet" href="../../css/dashboard.css">
    </head>
    <body>
        <p>you are now in agency_dashboard</p>
        <div class="myContainer"> 
        <div class="sidepanel"> 
            <h1>Welcome, John Doe</h1> 
            <a href="../traveller/logout.php">Logout</a>
         </div> 
         <div id="mainBoard"> 
           <button id="createPackage">Create Package</button> 
            
         </div> 
        
</div> 
        <script src = "../../js/agencyDashboard.js"></script> 
    </body>
</html>
