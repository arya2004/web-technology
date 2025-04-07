<?php
include 'db.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

echo "<h2>All Users</h2>";
echo "<table border='1'><tr><th>PRN</th><th>User Login</th><th>Password</th></tr>";

while($row = $result->fetch_assoc()) {
    echo "<tr><td>".$row["prn"]."</td><td>".$row["userlogin"]."</td><td>".$row["userpassword"]."</td></tr>";
}

echo "</table>";
$conn->close();
?>

<a href="/insert.php">Insert</a>
