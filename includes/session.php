<?php
    //Session management
    //Handles session initialization and user session functions

    session_start();

    function createSession($userID, $userType, $email){
        $_SESSION['userID'] = $userID;
        $_SESSION['userType'] = $userType;
        $_SESSION['email'] = $email;
    }

    //check if user logged in
    function checkUserLoggedIn(){
        return isset($_SESSION['userID']) && isset($_SESSION['userType']);
    }

    //get current userID
    function getCurrentUserID(){
        return $_SESSION['userID'] ?? null;
    }

    //get current user type
    function getCurrentUserType(){
        return $_SESSION['userType'] ?? null;
    }

    //check if user is logged in
    function isLoggedIn(){
        return isset($_SESSION['userID']) && isset($_SESSION['userType']);
    }

    //redirect if already logged in
    function redirectIfLoggedIn(){
        if (isLoggedIn()) {
            if (getCurrentUserType() === 'Traveller') {
                header("Location: traveller_dashboard.php");
            } else {
                header("Location: agency_dashboard.php");
            }
            exit();
        }
    }

    //redirect if not logged in
    function redirectIfNotLoggedIn(){
        if (!isLoggedIn()) {
            header("Location: login.php");
            exit();
        }
    }

    //redirect if not traveller
    function redirectIfNotTraveller(){
        if (!isLoggedIn() || getCurrentUserType() !== 'Traveller') {
            header("Location: login.php");
            exit();
        }
    }

    //redirect if not agent
    function redirectIfNotAgency(){
        if (!isLoggedIn() || getCurrentUserType() !== 'Agency') {
            header("Location: login.php");
            exit();
        }
    }

?>
