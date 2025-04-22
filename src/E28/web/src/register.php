<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username']);
    $p = $_POST['password'];
    $is_farmer = isset($_POST['is_farmer']) ? 1 : 0;
    $hash = password_hash($p, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, is_farmer) VALUES (?, ?, ?)");
    $stmt->execute([$u, $hash, $is_farmer]);

    header('Location: login.php');
    exit;
}
?>

<form method="post">
  <input name="username" placeholder="Username" required>
  <input name="password" type="password" placeholder="Password" required>
  <label><input type="checkbox" name="is_farmer"> Register as farmer</label>
  <button>Register</button>
</form>
