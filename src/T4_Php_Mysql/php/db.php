<?php
$host = 'db';
$user = 'test_user';
$pass = 'test_password';
$db = 'test_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
