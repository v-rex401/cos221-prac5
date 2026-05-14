<?php
    //input validation logic


    //validate email
    function isValidEmail($email){

    }

    function isValidCell($cell){

    }

    //validate password strength
    function isValidPassword($password){

    }

    //in signup you enter your password 2 times and they are checked against each other
    //check if password match
    function isPasswordMatch($password, $otherPassword){

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

    //XSS prevention: sanatise
    function sanitise($data){
        //ENT_QUOTES: convert '' and "" into HTML entities
        return htmlspecialchars((string) $data, ENT_QUOTES, 'UTF-8');
    }
?>
