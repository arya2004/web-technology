<?php
// src/public/add_employee.php
require_once __DIR__ . '/../config.php';
ensure_logged_in();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $position = trim($_POST['position'] ?? '');

    // Basic validation
    if (!$name || !$email || !$position) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        // Insert into DB
        $stmt = $pdo->prepare('INSERT INTO employees (name, email, position) VALUES (?, ?, ?)');
        try {
            $stmt->execute([$name, $email, $position]);
            $success = 'Employee added successfully!';
        } catch (PDOException $e) {
            if ($e->errorInfo[1] === 1062) {
                $error = 'Email already exists.';
            } else {
                $error = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

include 'header.php';
?>
<h2>Add Employee</h2>

<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlentities($error) ?></div>
<?php elseif ($success): ?>
  <div class="alert alert-success"><?= htmlentities($success) ?></div>
<?php endif; ?>

<form method="post">
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input name="name" type="text" class="form-control" id="name" value="<?= htmlentities($_POST['name'] ?? '') ?>" required>
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input name="email" type="email" class="form-control" id="email" value="<?= htmlentities($_POST['email'] ?? '') ?>" required>
  </div>
  <div class="mb-3">
    <label for="position" class="form-label">Position</label>
    <input name="position" type="text" class="form-control" id="position" value="<?= htmlentities($_POST['position'] ?? '') ?>" required>
  </div>
  <button type="submit" class="btn btn-success">Add</button>
  <a href="employees.php" class="btn btn-secondary">Back to List</a>
</form>

<?php include 'footer.php'; ?>
