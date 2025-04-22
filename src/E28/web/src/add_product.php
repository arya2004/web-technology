<?php

require 'config.php';

if(!($_SESSION['user_id'] && $_SESSION['is_farmer'])) {
    header('Location: login.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];

    $stmt = $pdo->prepare("INSERT INTO products (user_id, name, description, price) values (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $name, $desc, $price]);

    header('Location: index.php');
    exit;
}


?>




<form method="post">
  <input name="name" placeholder="Product name" required>
  <textarea name="description" placeholder="Description"></textarea>
  <input name="price" type="number" step="0.01" placeholder="Price" required>
  <button>Add Product</button>
</form>