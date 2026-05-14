<?php
    
    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/includes/database.php';
    require_once __DIR__ . '/includes/auth.php';
    
    // Check access
    redirectIfNotTraveller();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traveller Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <p>you are now in traveller_dashboard</p>
    <a href="logout.php">Logout</a>
</body>
</html>
