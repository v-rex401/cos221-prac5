<?php
    //traveller + agency signup

    require_once __DIR__ . '/handlers/signup_handler.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Tripistry</title>

    //TODO: add corresponding css scripts
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="">

    <script src=""></script> //TODO: add corresponding JS script for radio button handling for different users
</head>
<body class="auth-page">
    <?php include __DIR__ . "/header.php"; ?>
    <div class="form-wrap auth-form-wrap">
        <form id="signupForm" method="post">
            <div class="box one-col">
                <h1 class="auth-title">Create Account</h1>

                <input type="hidden" name="type" value="Register">
                <div>
                    <label>Name</label><br><input type = "text" id = "name" name="name">
                </div>
                <div>
                    <label>Surname</label><br><input type="text" id = "surname" name="surname">
                </div>

                <div>
                    <label>Email</label><br><input type="text" id = "email" name="email">
                </div>

                <div>
                    <label>Password</label><br><input type="password" id = "password" name="password">
                </div>

                <div class="radio-group">
                    <label>Account Type:</label><br>
                    <label>
                        <input type="radio" name="user_type" value="Traveller" required <?php echo ($userType === 'Traveller' || empty($userType)) ? 'checked' : ''; ?>>
                        Traveller
                    </label>
                    <label>
                        <input type="radio" name="user_type" value="Agency" required <?php echo ($userType === 'Agency') ? 'checked' : ''; ?>>
                        Travel Agency
                    </label>
                </div>

            </div>
            <input class="submit_button" type="submit" value="Create Account">

            <div>
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>

        </form>
    </div>
</body>
</html>


<!--Reference: https://www.w3schools.com/php/php_form_validation.asp -->

