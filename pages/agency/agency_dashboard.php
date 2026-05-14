<?php
    //view the packages
    //basically the same as the traveller side but just without the option to book a package
    //use same filtering system as traveller

    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/includes/database.php';
    require_once __DIR__ . '/includes/auth.php';

    redirectIfNotAgency();

    // Get user data
    $userID = getCurrentUserID();
    $agency = getAgencyByUserID($userID);
    
    if (!$agency) {
        header("Location: logout.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Dashboard</title>
</head>
<body>
    
</body>
</html>
