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
        
    }

    //get current userID
    function getCurrentUserID(){

    }

    //get current user type
    function getCurrentUserType(){

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
