<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fga = array($_POST["prn"], $_POST["userlogin"], $_POST["userpassword"]);
    $keys = ["prn", "userlogin", "userpassword"];
    $row = array_combine($keys, $fga);

    
    $stmt = $conn->prepare("INSERT INTO users (prn, userlogin, userpassword) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $row["prn"], $row["userlogin"], $row["userpassword"]);

    if ($stmt->execute()) {
        echo "Data inserted successfully.";
    } else {
        echo "Insert failed: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<h2>Insert User</h2>
<form method="POST" action="">
    <label>PRN:</label><br>
    <input type="text" name="prn" required><br><br>

    <label>User Login:</label><br>
    <input type="text" name="userlogin" required><br><br>

    <label>User Password:</label><br>
    <input type="password" name="userpassword" required><br><br>

    <input type="submit" value="Insert">
</form>

<a href="/showall.php">Showall</a>