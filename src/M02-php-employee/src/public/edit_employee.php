<?php
// src/public/edit_employee.php
require_once __DIR__ . '/../config.php';
ensure_logged_in();

$error = '';
$success = '';

// Get ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header('Location: employees.php');
    exit;
}

// Fetch existing
$stmt = $pdo->prepare('SELECT * FROM employees WHERE id = ?');
$stmt->execute([$id]);
$emp = $stmt->fetch();
if (!$emp) {
    header('Location: employees.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $position = trim($_POST['position'] ?? '');

    if (!$name || !$email || !$position) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        $upd = $pdo->prepare('UPDATE employees SET name = ?, email = ?, position = ? WHERE id = ?');
        try {
            $upd->execute([$name, $email, $position, $id]);
            $success = 'Employee updated successfully!';
            // Refresh data
            $emp['name']     = $name;
            $emp['email']    = $email;
            $emp['position'] = $position;
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
<h2>Edit Employee #<?= $emp['id'] ?></h2>

<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlentities($error) ?></div>
<?php elseif ($success): ?>
  <div class="alert alert-success"><?= htmlentities($success) ?></div>
<?php endif; ?>

<form method="post">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input name="name" type="text" class="form-control" value="<?= htmlentities($emp['name']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input name="email" type="email" class="form-control" value="<?= htmlentities($emp['email']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Position</label>
    <input name="position" type="text" class="form-control" value="<?= htmlentities($emp['position']) ?>" required>
  </div>
  <button type="submit" class="btn btn-primary">Save Changes</button>
  <a href="employees.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include 'footer.php'; ?>
