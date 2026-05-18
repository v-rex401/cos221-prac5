<?php
    //Authentication functions
    //Login, registration (signup), login, verification

    require_once __DIR__ . '/database.php';

    //registering new user (traveller or agent)
    function registerUser($name, $email, $cell, $password, $userType){
        global $conn;

        //PASSWORD_BCRYPT uses blowfish hashing algo internally
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $statement = $conn->prepare("INSERT INTO users (Name, Password_Hash, Email, Cell, Type)
                                    VALUES (?, ?, ?, ?, ?)");
        
        if(!$statement){
            return ['success' => false, 'error' =>'Database error: '. $conn->error];
        }

        // Order MUST match INSERT columns: Name, Password_Hash, Email, Cell, Type
        $statement->bind_param("sssss", $name, $passwordHash, $email, $cell, $userType);
        if (!$statement->execute()) {
            $err = $statement->error;
            $statement->close();
            return ['success' => false, 'error' => 'Error creating account: ' . $err];
        }

        $userID = $conn->insert_id;
        $statement->close();

        return ['success' => true, 'userID' => $userID];
    }

    //authenticate user (find in database)
    //login
    function authenticateUser($email, $password, $userType){
        global $conn;

        $statement = $conn->prepare("SELECT User_ID, Name, Password_Hash, Email, Type
                                    FROM users
                                    WHERE Email = ? AND Type = ?");
        if(!$statement){
            return ['success' => false, 'error' =>'Database error: '. $conn->error];
        }

        $statement->bind_param("ss", $email, $userType);
        $statement->execute();
        $result = $statement->get_result();

        if($result->num_rows === 1){
            $user = $result->fetch_assoc();
            $statement->close();

            if(password_verify($password, $user['Password_Hash'])){
                return ['success' => true, 'user'=>$user];
            }else{
                $statement->close();
            }
        }
        return ['success' => false, 'error' => 'Invalid email or password'];
    }

    //check if email already exists
    function emailExists($email){
        //returns true if email exists in database
        global $conn;

        $statement = $conn->prepare("SELECT User_ID FROM users WHERE Email = ?");

        if(!$statement){
            return false;
        }
        $statement->bind_param("s", $email);
        $statement->execute();

        $result = $statement->get_result();

        $exists = $result->num_rows > 0;
        $statement->close();

        return $exists;

    }

    //get user details by ID
    function getUserByID($userID){
        global $conn;

        $statement = $conn->prepare("SELECT User_ID FROM users WHERE User_ID = ?");

        if(!$statement){
            return ['success' => false, 'error' =>'Database error: '. $conn->error];
        }
        $statement->bind_param("s", $userID);
        $statement->execute();

        $result = $statement->get_result();

        if($result->num_rows === 0){
            return ['success' => false, 'error' => 'Invalid user'];
        }
        $user = $result->fetch_assoc();

        $statement->close();

        return ['success' => true, 'user' => $user];

    }

    //get agency details by ID
    function getAgencyByUserID($userID){
        global $conn;

        $statement = $conn->prepare("SELECT User_ID, Name, Email, Type FROM users WHERE User_ID = ? AND Type = 'Agency'");

        if(!$statement){
            return ['success' => false, 'error' =>'Database error: '. $conn->error];
        }
        $statement->bind_param("s", $userID);
        $statement->execute();

        $result = $statement->get_result();

        if($result->num_rows === 0){
            return ['success' => false, 'error' => 'User not found or not an agency'];
        }
        $user = $result->fetch_assoc();

        $statement->close();

        return ['success' => true, 'user' => $user];
    }

    //get agency details by ID
    function getTravellerByUserID($userID){
        global $conn;

        $statement = $conn->prepare("SELECT User_ID, Name, Email, Type FROM users WHERE User_ID = ? AND Type = 'Traveller'");

        if(!$statement){
            return ['success' => false, 'error' =>'Database error: '. $conn->error];
        }
        $statement->bind_param("s", $userID);
        $statement->execute();

        $result = $statement->get_result();

        if($result->num_rows === 0){
            return ['success' => false, 'error' => 'User not found or not a Traveller'];
        }
        $user = $result->fetch_assoc();

        $statement->close();

        return ['success' => true, 'user' => $user];
    }
?>
