<?php
    //traveller + agency signup

    require_once __DIR__ . '/../handlers/signup_handler.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Tripistry</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/auth.css">
</head>
<body>
    <div class="signup-container">
        <h1>Create Account</h1>

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo sanitise($error); ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="success">
                <?php echo sanitise($success); ?>
                <a href="login.php">Proceed to login</a>
            </div>
        <?php endif; ?>

        <form id="signupForm" method="POST" action="">
            <div>
                <label for="name">Name and Surname</label><br>
                <input type="text" id="name" name="name" required value="<?php echo sanitise($name); ?>">
            </div>

            <div>
                <label for="email">Email</label><br>
                <input type="text" id="email" name="email" required value="<?php echo sanitise($email); ?>">
            </div>

            <div>
                <label for="cell">Cell</label><br>
                <input type="text" id="cell" name="cell" required value="<?php echo sanitise($cell); ?>">
            </div>

            <div>
                <label for="password">Password</label><br>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="password_confirm">Confirm Password</label><br>
                <input type="password" id="password_confirm" name="password_confirm" required>
            </div>

            <div class="radio-group">
                <label>Account Type:</label><br>
                <label>
                    <input type="radio" name="user_type" value="Traveller" required
                    <?php if ($userType === 'Traveller' || empty($userType)) { echo 'checked'; } ?>>
                    Traveller
                </label>
                <label>
                    <input type="radio" name="user_type" value="Agency" required
                    <?php if ($userType === 'Agency') { echo 'checked'; } ?>
                    >
                    Travel Agency
                </label>
            </div>

            <input class="submit_button" type="submit" value="Create Account">

            <div class="link-group">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </form>
    </div>
</body>
</html>



