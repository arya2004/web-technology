<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Exployees</h1>
    <a href="add_employee.php"> Add new </a>

    <table border="1" cellpadding="5">

    <tr>
    <th>ID</th>
    <th>name</th>   
    <th>Email</th>
    <th>Department</th>
    </tr>

    <?php
    $result = $conn->query("SELECT * FROM employees");
    while($row = $result->fetch_assoc()){
        echo "
        
        <tr>
            <td>{$row['id']}</td><td>{$row['name']}</td>
                <td>{$row['email']}</td><td>{$row['department']}</td>
        </tr>
        
        ";
    }
    ?>
    
    </table>
    
</body>
</html>
