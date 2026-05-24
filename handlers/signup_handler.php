<?php

    //Process signup form submission

    require_once __DIR__ . '/../includes/session.php';
    require_once __DIR__ . '/../includes/database.php';
    require_once __DIR__ . '/../includes/auth.php';
    require_once __DIR__ . '/../includes/validation.php';


    $error = "";
    $success = "";
    $name = "";
    $email = "";
    $cell = "";
    $userType = "";

    //check if already logged in
    redirectIfLoggedIn();

    //process form submission
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $cell = trim($_POST['cell'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        $userType = trim($_POST['user_type'] ?? '');

        //Validate input
        $errors = validateSignupForm($name, $email, $cell, $password, $passwordConfirm, $userType);

        if(!empty($errors)){
            $error = $errors[0];
        }elseif(emailExists($email)){
            $error = "Email already registered";
        }else{
            //register user
            $result = registerUser($name, $email, $cell, $password, $userType);

            if($result['success']){
                //log the new user in straight away so no login step is needed
                createSession($result['userID'], $userType, $email);

                //redirect directly to the relevant dashboard
                if($userType === 'Traveller'){
                    redirectTo('pages/traveller/traveller_dashboard.php');
                }else{
                    redirectTo('pages/agency/agency_dashboard.php');
                }
            }else{
                $error = $result['error'];
            }
        }
    }

?>
