<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username']);
    $p = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$u]);
    $user = $stmt->fetch();

    if($user && password_verify($p, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_farmer'] = $user['is_farmer'];
        header('Location: index.php');
        exit;
    } else  {
        echo 'invalid creds';
    }
}

?>


<form method="post">
    <input type="text" name="username" placeholder="username" required>
    <input name="password" type="password" placeholder="passwd" required>
    <button>Login</button>
</form>