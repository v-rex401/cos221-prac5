<?php

    //split userType (Traveller or agency on this page)

    require_once __DIR__ . '/includes/session.php';

    // If user is logged in, redirect to their dashboard
    if (checkUserLoggedIn()) {
        if (getCurrentUserType() === 'Traveller') {
            redirectTo('pages/traveller/traveller_dashboard.php');
        } else {
            redirectTo('pages/agency/agency_dashboard.php');
        }
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
            
            <!-- In nav bar-->
            <nav>
                <a href="pages/login.php">Login</a>
                <a href="pages/signup.php">Sign Up</a>
            </nav>
        </header>

        <main>
            <section class="hero">
                <div class="cta-buttons">
                    <!-- On page big buttons-->
                    <a href="pages/login.php">Login</a>
                    <a href="pages/signup.php">Create Account</a>
                </div>
            </section>
        </main>
    </body>
</html>

