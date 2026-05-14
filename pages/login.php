<?php
    
    //traveller + agency login

    require_once __DIR__ . '/handlers/login_handler.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>

        <link rel="stylesheet" href="css/auth.css">

    </head>
    <body>
        <div class="login-container">
            <h1>Tripistry Login</h1>

            <?php if (!empty($error)): ?>
                <div class="error"><?php echo sanitise($error); ?></div>
            <?php endif; ?>

            <form id="loginForm" method="POST" action="">
                <div>
                    <label for="email">Email</label><br>
                    <input type="text" id="email" name="email" required value="<?php echo sanitise($email); ?>">
                </div>

                <div>
                    <label for="password">Password</label><br>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="radio-group">
                    <label>Login as:</label><br>
                    <label>
                        <input type="radio" name="user_type" value="Traveller" required <?php echo ($userType === 'Traveller' || empty($userType)) ? 'checked' : ''; ?>>
                        Traveller
                    </label>
                    <label>
                        <input type="radio" name="user_type" value="Agency" required <?php echo ($userType === 'Agency') ? 'checked' : ''; ?>>
                        Agency
                    </label>
                </div>

                <input class="submit_button" type="submit" value="Log in">

                <div class="link-group">
                    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
                </div>
            </form>
        </div>
    </body>
</html>

<?php
    /*
    login.php

    includes handler: login_handler.php

    calls: validateLoginForm() from validation.php

    calls: authenticateUser() from auth.php

    calls: database.php for query

    creates session via session.php

    redirects to dashboard
    */
?>
