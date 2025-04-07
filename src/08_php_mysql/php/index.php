<?php
$host = 'db';
$user = 'test_user';
$password = 'test_password';
$database = 'test_db';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $first_name = $_POST['first_name'];
    $age = $_POST['age'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("INSERT INTO test_table (first_name, age, address) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $first_name, $age, $address);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit;
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM test_table WHERE id=$id");
    header("Location: index.php");
    exit;
}


$result = $conn->query("SELECT * FROM test_table");
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP CRUD</title>
</head>
<body>
    <h1>PHP CRUD - People</h1>

    <h2>Add New</h2>
    <form method="POST">
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="number" name="age" placeholder="Age" required>
        <input type="text" name="address" placeholder="Address" required>
        <button type="submit" name="create">Add</button>
    </form>

    <h2>People List</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th><th>Name</th><th>Age</th><th>Address</th><th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['first_name']) ?></td>
            <td><?= $row['age'] ?></td>
            <td><?= htmlspecialchars($row['address']) ?></td>
            <td><a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this entry?')">Delete</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>

Include
dbconnect php
insert php
show php file