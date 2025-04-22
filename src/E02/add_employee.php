<?php

include 'config.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $department = $_POST['department'] ?? '';

    $stmt = $conn->prepare("INSERT INTO employees (name, email, department) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $department);
    $stmt->execute();
    header("Location: index.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Add emp</h2>

    <form  method="post">
        Name: <input type="text" name="name" required> <br>
        Email: <input type="text" name="email" required> <br>
        Dept: <input type="text" name="department"> <br>
        <input type="submit" value="add"> 
    </form>
    
</body>
</html>