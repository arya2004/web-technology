<?php

$host = 'db';
$db = 'employees';
$user = 'root';
$pass = 'root';


$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("conn failled: " . $conn->connect_error);
}

?>