<?php
$host = 'db';
$user = 'test_user';
$password = 'test_password';
$database = 'test_db';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected to MySQL successfully!<br>";

// Fetch data
$result = $conn->query("SELECT * FROM test_table");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " - Name: " . $row['name'] . "<br>";
    }
} else {
    echo "No data found.";
}

$conn->close();
?>
