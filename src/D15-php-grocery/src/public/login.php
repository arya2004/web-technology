<?php
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $error    = '';

    if (!$email || !$password) {
        $error = 'Email and password are required.';
    } else {
        // Fetch user
        $stmt = $pdo->prepare('SELECT * FROM consumers WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Success
            $_SESSION['user'] = [
                'id'   => $user['id'],
                'name' => $user['name'],
                'email'=> $user['email'],
                'role' => $user['role']
            ];
            header('Location: catalogue.php');
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    }
}

include __DIR__ . '/header.php';
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" novalidate>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" name="email" type="email"
               class="form-control" required
               value="<?= htmlspecialchars($email ?? '') ?>">
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" name="password" type="password"
               class="form-control" required>
      </div>

      <button class="btn btn-primary" type="submit">Login</button>
    </form>

    <p class="mt-3">
      Don't have an account? <a href="register.php">Register here</a>.
    </p>
  </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
