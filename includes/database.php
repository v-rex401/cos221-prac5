<?php
    $db_host = "localhost";
    $db_name = "u24611400_Tripistry";
    $db_user = "u24611400";

    $db_password_file = __DIR__ . "/../db_password";
    $password = trim((string) file_get_contents($db_password_file));

    //DB connection using MySQLi
    $conn = new mysqli($db_host, "u24611400", $password, $db_name);

    //check connection
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    //char encoding for different characters other than ascii
    $conn->set_charset("utf8mb4");
?>
