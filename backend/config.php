<?php
// config.php - Database connection for CVA Bulletin

// Database credentials
$host = 'localhost';          // usually localhost
$db   = 'cva_bulletin';       // your database name
$user = 'db_username';        // replace with your DB username
$pass = 'db_password';        // replace with your DB password
$charset = 'utf8mb4';         // charset for full UTF-8 support

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // throw exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // use native prepares
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // If DB connection fails, exit with error
    exit('Database connection failed: ' . $e->getMessage());
}
?>
