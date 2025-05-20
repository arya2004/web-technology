<?php
// src/public/index.php
require_once __DIR__ . '/../config.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: employees.php');
} else {
    header('Location: login.php');
}
exit;
