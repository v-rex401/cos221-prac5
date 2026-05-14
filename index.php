<?php

    //split userType (Traveller or agency on this page)

    session_start();

    if (isset($_SESSION['userID'])) {
    if ($_SESSION['userType'] === 'Traveller') {
        header("Location: traveller_dashboard.php");
    } else {
        header("Location: agency_dashboard.php");
    }

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tripistry</title>
    
    <!-- Link css-->
    <link rel="stylesheet" href="css/navbar.css?">
</head>

<body class="book-page">
    <!-- absolute path of directory-->
    <?php include __DIR__ . "/php/header.php"; ?>

</body>

</html>



