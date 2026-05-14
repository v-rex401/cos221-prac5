<?php

    //split userType (Traveller or agency on this page)

    require_once __DIR__ . '/includes/session.php';

    // If user is logged in, redirect to their dashboard
    if (checkUserLoggedIn()) {
        if (getCurrentUserType() === 'Traveller') {
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
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <header>
            <div class="logo">Tripistry</div>
            <nav>
                <a href="login.php">Login</a>
                <a href="signup.php">Sign Up</a>
            </nav>
        </header>

        <main>
            <section class="hero">
                <div class="cta-buttons">
                    <a href="login.php">Login</a>
                    <a href="signup.php">Create Account</a>
                </div>
            </section>
        </main>
    </body>
</html>

