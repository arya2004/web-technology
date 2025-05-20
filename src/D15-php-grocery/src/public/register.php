<?php
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gather & sanitize
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = $_POST['role'] ?? 'user';
    $error    = '';

    if (!$name || !$email || !$password || !in_array($role, ['user','admin'])) {
        $error = 'All fields are required and role must be user or admin.';
    } else {
        // Check existing email
        $stmt = $pdo->prepare('SELECT id FROM consumers WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Email already registered.';
        } else {
            // Insert
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins  = $pdo->prepare(
                'INSERT INTO consumers (name,email,password,role) VALUES (?,?,?, ?)'
            );
            $ins->execute([$name, $email, $hash, $role]);
            header('Location: login.php');
            exit;
        }
    }
}

include __DIR__ . '/header.php';
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <h2>Register</h2>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" novalidate>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input id="name" name="name" type="text"
               class="form-control" required
               value="<?= htmlspecialchars($name ?? '') ?>">
      </div>

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

      <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select id="role" name="role" class="form-select" required>
          <option value="user" <?= ( ($role??'')==='user' ? 'selected' : '' ) ?>>User</option>
          <option value="admin" <?= ( ($role??'')==='admin' ? 'selected' : '' ) ?>>Admin</option>
        </select>
      </div>

      <button class="btn btn-success" type="submit">Register</button>
    </form>

    <p class="mt-3">
      Already have an account? <a href="login.php">Login here</a>.
    </p>
  </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
