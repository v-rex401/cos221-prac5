<?php
    //input validation logic


    //validate email
    function isValidEmail($email){
        //regex check for format
        $emailRegex = '/^(([^<>()\[\]\.,;:\s@"]+(\.[^<>()\[\]\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
        if (preg_match($emailRegex, $email)) {
            $errors[] =  "Valid email";
            return true;
        } else {
            $errors[] = "Invalid email";
            return false;
        }
    }

    function isValidCell($cell){
        $errors = [];
        //regex check
        $regex = '/^(?:\+27[\s-]?|0)(?:6|7|8)[0-9](?:[\s-]?[0-9]{3}[\s-]?[0-9]{4}|[0-9]{7})$/';

        if (preg_match($regex, $cell)) {
            $errors[] =  "Valid number";
            return true;
        } else {
            $errors[] = "Invalid number";
            return false;
        }
    }

    //validate password strength
    function isValidPassword($password){
        
        if(strlen($password) <= 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password)
        || !preg_match('/\d/', $password) || !preg_match('/[\W_]/', $password)){
            $errors [] = "Invalid password";
            return false;
        }
        return true;
    }

    //in signup you enter your password 2 times and they are checked against each other
    //check if password match
    //note this is not checking if password is the same as one in the database.
    function isPasswordMatch($password, $otherPassword){
        $errors = [];
        if($password != $otherPassword){
            $errors = "Invalid password";
            return false;
        }
        return true;
    }

    //validate login form inputs
    function validateLoginForm($email, $password, $userType){
        $errors = [];

        if(empty($email)){
            $errors[] = "Email is required";
        }else if(!isValidEmail($email)){
            $errors[] = "Invalid email format";
        }

        if(empty($password)){
            $errors[] = "Password is required";
        }

        if(empty($userType)){
            $errors[] = "User type is required";
        }else if(!in_array($userType, ['Traveller', 'Agency'])){
            $errors[] = "Invalid user type";
        }
        return $errors;
    }

    //validate signup form inputs
    function validateSignupForm($name, $email, $cell, $password, $passwordConfirm, $userType){
        $errors = [];

        if(empty($name)){
            $errors[] = "Name is required";
        }

        if(empty($email)){
            $errors[] = "Email is required";
        }else if(!isValidEmail($email)){
            $errors[] = "Invalid email format";
        }

        if(empty($cell)){
            $errors[] = "Cell number is required";
        }else if(!isValidCell($cell)){
            $errors[] = "Cell number must be between 10-20 characters";
        }

        if(empty($password)){
            $errors[] = "Password is required";
        }elseif(!isValidPassword($password)) {
            $errors[] = "Password must be at least 6 characters";
        }

        if(empty($passwordConfirm)){
            $errors[] = "Password confirmation is required";
        }elseif(!isPasswordMatch($password, $passwordConfirm)) {
            $errors[] = "Passwords do not match";
        }

        if(empty($userType)){
            $errors[] = "User type is required";
        }else if(!in_array($userType, ['Traveller', 'Agency'])){
            $errors[] = "Invalid user type";
        }
        return $errors;
    }

    //XSS prevention: sanitise
    function sanitise($data){
        //ENT_QUOTES: convert '' and "" into HTML entities
        return htmlspecialchars((string) $data, ENT_QUOTES, 'UTF-8');
    }
?>
