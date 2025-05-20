<?php
// src/public/login.php
require_once __DIR__ . '/../config.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: employees.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $pass  = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT id, password FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: employees.php');
        exit;
    } else {
        $error = 'Invalid email or password.';
    }
}

include 'header.php';
?>
<h2>Admin Login</h2>
<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlentities($error) ?></div>
<?php endif; ?>
<form method="post">
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input name="email" type="email" class="form-control" id="email" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input name="password" type="password" class="form-control" id="password" required>
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
</form>
<?php include 'footer.php'; ?>
