<?php
require 'config.php';

if (!($_SESSION['user_id'] && $_SESSION['is_farmer'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];

    $stmt = $pdo->prepare("INSERT INTO products (user_id, name, description, price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $name, $desc, $price]);

    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - Agri Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Agri Shop</a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="card shadow p-4 mx-auto" style="max-width: 600px;">
        <h3 class="mb-4 text-center">Add New Product</h3>

        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Enter product name" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description" placeholder="Enter product description" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price (₹)</label>
                <input name="price" type="number" step="0.01" class="form-control" id="price" placeholder="Enter price" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Add Product</button>
        </form>
    </div>
</div>

</body>
</html>
