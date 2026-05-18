<?php

    //Process login form submission

    require_once __DIR__ . '/../includes/session.php';
    require_once __DIR__ . '/../includes/database.php';
    require_once __DIR__ . '/../includes/auth.php';
    require_once __DIR__ . '/../includes/validation.php';

    $error    = "";
    $email    = "";
    $userType = "";

    //check if already logged in
    redirectIfLoggedIn();

    //process form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $userType = trim($_POST['user_type'] ?? '');

        //Validate input
        $errors = validateLoginForm($email, $password, $userType);

        if(!empty($errors)){
            $error = $errors[0];
        }else{
            //authenticate user
            $result = authenticateUser($email, $password, $userType);

            if($result['success']){
                $user = $result['user'];
                //set session variables
                createSession($user['User_ID'], $user['Type'], $user['Email']);

                //redirect to different dashboard
                if($user['Type'] === 'Traveller'){
                    redirectTo('pages/traveller/traveller_dashboard.php');
                }else{
                    redirectTo('pages/agency/agency_dashboard.php');
                }
            } else {
                $error = $result['error'];
            }
        }
    }
?>
