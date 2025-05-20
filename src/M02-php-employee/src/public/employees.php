<?php
// src/public/employees.php
require_once __DIR__ . '/../config.php';
ensure_logged_in();

// Handle delete if via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delStmt = $pdo->prepare('DELETE FROM employees WHERE id = ?');
    $delStmt->execute([ (int)$_POST['delete_id'] ]);
    header('Location: employees.php');
    exit;
}

// Fetch employees
$stmt = $pdo->query('SELECT * FROM employees ORDER BY created_at DESC');
$employees = $stmt->fetchAll();

include 'header.php';
?>
<h2>Employee List</h2>

<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Email</th>
      <th>Position</th>
      <th>Added On</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($employees as $emp): ?>
      <tr>
        <td><?= $emp['id'] ?></td>
        <td><?= htmlentities($emp['name']) ?></td>
        <td><?= htmlentities($emp['email']) ?></td>
        <td><?= htmlentities($emp['position']) ?></td>
        <td><?= $emp['created_at'] ?></td>
        <td>
          <a href="edit_employee.php?id=<?= $emp['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
          <form method="post" style="display:inline" onsubmit="return confirm('Delete this employee?');">
            <input type="hidden" name="delete_id" value="<?= $emp['id'] ?>">
            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include 'footer.php'; ?>
