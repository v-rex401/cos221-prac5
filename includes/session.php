<?php
    //Session management
    //Handles session initialization and user session functions

    session_start();

    /*  Helper: resolve a path relative to the project root and redirect.
        Works whether called from /cos221-prac5/index.php, /cos221-prac5/pages/login.php
        or /cos221-prac5/pages/traveller/foo.php — strips the known sub-folders off
        the current script's directory.  */
    function redirectTo($pathFromProjectRoot){
        $base = dirname($_SERVER['SCRIPT_NAME'] ?? '');
        $base = preg_replace('#/(pages(/[^/]+)?|handlers|includes)$#', '', $base);
        if ($base === '/' || $base === '.' || $base === '\\') $base = '';
        header("Location: {$base}/{$pathFromProjectRoot}");
        exit();
    }

    function createSession($userID, $userType, $email){
        // Prevent session fixation: issue a fresh session ID on login so that
        // any session ID set before authentication is discarded. The `true`
        // argument also deletes the old session file.
        session_regenerate_id(true);

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
                redirectTo('pages/traveller/traveller_dashboard.php');
            } else {
                redirectTo('pages/agency/agency_dashboard.php');
            }
        }
    }

    //redirect if not logged in
    function redirectIfNotLoggedIn(){
        if (!isLoggedIn()) {
            redirectTo('pages/login.php');
        }
    }

    //redirect if not traveller
    function redirectIfNotTraveller(){
        if (!isLoggedIn() || getCurrentUserType() !== 'Traveller') {
            redirectTo('pages/login.php');
        }
    }

    //redirect if not agent
    function redirectIfNotAgency(){
        if (!isLoggedIn() || getCurrentUserType() !== 'Agency') {
            redirectTo('pages/login.php');
        }
    }

?>
