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

    //TODO: add corresponding css scripts
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="">

    <script src=""></script> //TODO: add corresponding JS script
</head>
<body class="auth-page">
    <?php include __DIR__ . "/header.php"; ?>
    <div class="form-wrap auth-form-wrap">
        <title>Tripistry Login</title>
        <form id="signupForm" method="post">
            <div class="box one-col">
                <h1 class="auth-title">Login</h1>

                <div>
                    <label>Email</label><br><input type="text" id = "email" name="email">
                </div>

                <div>
                    <label>Password</label><br><input type="password" id = "password" name="password">
                </div>

            </div>

            <div class="radio-group">
                <label>Login as:</label><br>
                <label>
                    <input type="radio" name="user_type" value="Traveller" required <?php echo ($userType === 'Traveller') ? 'checked' : ''; ?>>
                    Traveller
                </label>
                <label>
                    <input type="radio" name="user_type" value="Agency" required <?php echo ($userType === 'Agency') ? 'checked' : ''; ?>>
                    Agency
                </label>
            </div>

            <div id="message" style="display:none;"></div>
            <input class="submit_button" type="submit" value="Log in">

            <div>
                <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
            </div>
        </form>
    </div>
</body>
</html>


<!--Reference: https://www.w3schools.com/php/php_form_validation.asp -->
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
