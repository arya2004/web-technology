<?php
// Start session for auth
session_start();

// Database credentials
define('DB_HOST', 'db');          // must match the service name in docker-compose
define('DB_NAME', 'grocerydb');
define('DB_USER', 'appuser');
define('DB_PASS', 'apppass');


try {
    // PDO connection
    $pdo = new PDO(
        'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    // On failure, show error and exit
    echo "Database connection failed: " . htmlspecialchars($e->getMessage());
    exit;
}

// Helper: is user logged in?
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// Helper: current user role ('user' or 'admin')
function currentUserRole() {
    return $_SESSION['user']['role'] ?? null;
}

// Helper: redirect to login if not authenticated
function requireAuth() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}
