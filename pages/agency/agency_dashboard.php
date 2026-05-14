<?php
    //view the packages
    //basically the same as the traveller side but just without the option to book a package
    //use same filtering system as traveller

    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/includes/database.php';
    require_once __DIR__ . '/includes/auth.php';

    //check access
    redirectIfNotAgency();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Agency Dashboard</title>
        <link rel="stylesheet" href="css/dashboard.css">
    </head>
    <body>
        <p>you are now in agency_dashboard</p>
        <a href="logout.php">Logout</a>
    </body>
</html>
