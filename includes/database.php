<?php
    // Detect whether we are running locally (XAMPP) or on Wheatley.
    // On Wheatley HTTP_HOST will be wheatley.cs.up.ac.za;
    // locally it will be localhost / 127.0.0.1.
    $http_host = $_SERVER['HTTP_HOST'] ?? '';
    $is_local  = (
        strpos($http_host, 'localhost') !== false ||
        strpos($http_host, '127.0.0.1') !== false ||
        php_sapi_name() === 'cli'
    );

    $db_host = "localhost";
    $db_name = "u24611400_Tripistry";

    if ($is_local) {
        // XAMPP defaults
        $db_user     = "root";
        $db_password = "";
    } else {
        // Wheatley credentials
        $db_user             = "u24611400";
        $db_password_file    = __DIR__ . "/../db_password";
        $db_password         = trim((string) file_get_contents($db_password_file));
    }

    //DB connection using MySQLi
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    //check connection
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    //char encoding for different characters other than ascii
    $conn->set_charset("utf8mb4");
?>
