<?php
    // ---------------------------------------------------------------
    // Database connection for Tripistry.
    //
    // Credentials are loaded from a .env file (not committed to git)
    // using the vlucas/phpdotenv package. To set up:
    //   1. Run "composer install" once in the project root.
    //   2. Copy ".env.example" to ".env".
    //   3. Fill in your own database credentials in ".env".
    // ---------------------------------------------------------------

    // Load Composer's autoloader so vlucas/phpdotenv is available.
    $autoload = __DIR__ . '/../vendor/autoload.php';
    if (!file_exists($autoload)) {
        die('Dependencies not installed. Run "composer install" in the project root.');
    }
    require_once $autoload;

    // Load environment variables from the .env file in the project root.
    // safeLoad() does not throw if .env is missing, so the fallback
    // defaults below still allow the app to run on a fresh checkout.
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->safeLoad();

    // Read DB credentials from the environment.
    // The fallback values match a default XAMPP install.
    $db_host     = $_ENV['DB_HOST']     ?? 'localhost';
    $db_name     = $_ENV['DB_NAME']     ?? 'u24611400_Tripistry';
    $db_user     = $_ENV['DB_USER']     ?? 'root';
    $db_password = $_ENV['DB_PASSWORD'] ?? '';

    // DB connection using MySQLi.
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    // Check connection.
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Char encoding for characters other than ASCII.
    $conn->set_charset("utf8mb4");
?>
