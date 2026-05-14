<?php
    
    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/includes/database.php';
    require_once __DIR__ . '/includes/auth.php';
    
    // Check access
    redirectIfNotTraveller();
    
    // Get user data
    $userID = getCurrentUserID();
    $user = getUserByID($userID);
    
    if (!$user) {
        header("Location: logout.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traveller Dashboard</title>
</head>
<body>

</body>
</html>
