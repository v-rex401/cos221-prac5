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

    //redirect if already logged in
    function redirectIfLoggedIn(){

    }

    //redirect if not logged in
    function redirectIfNotLoggedIn(){

    }

    //redirect if not traveller
    function redirectIfNotTraveller(){

    }

    //redirect if not agent
    function redirectIfNotAgency(){

    }

?>
