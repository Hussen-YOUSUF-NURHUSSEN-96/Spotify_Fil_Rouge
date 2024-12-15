<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'Music platform');
define('DB_USER', 'root');
define('DB_PASSWORD', 'Roshan');
define('DB_PORT', '3306'); // Adjust the port if necessary

// Establish a PDO connection
function connect_to_db() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error connecting to the database: " . $e->getMessage());
    }
}
