<?php
session_start();

define('DB_HOST', 'db');
define('DB_NAME', 'grocerydb');
define('DB_USER', 'appuser');
define('DB_PASS', 'apppass');

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Helper: require login
function ensure_logged_in() {
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}
