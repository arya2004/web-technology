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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Agri Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="min-width: 320px; max-width: 450px; width: 100%;">
        <h3 class="text-center mb-4">Register for Agri Shop</h3>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input name="username" type="text" class="form-control" placeholder="Choose a username" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input name="password" type="password" class="form-control" placeholder="Create a password" required>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_farmer" id="is_farmer">
                <label class="form-check-label" for="is_farmer">
                    Register as a farmer
                </label>
            </div>

            <button type="submit" class="btn btn-success w-100">Register</button>
        </form>

        <p class="text-center mt-3 mb-0">
            <a href="login.php">Already have an account? Login</a>
        </p>
    </div>
</div>

</body>
</html>
