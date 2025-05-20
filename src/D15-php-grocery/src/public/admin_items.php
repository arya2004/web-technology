<?php
require_once __DIR__ . '/config.php';
requireAuth();
if (currentUserRole() !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    echo "Access denied.";
    exit;
}

include __DIR__ . '/header.php';

// Fetch all items
$stmt = $pdo->query('SELECT * FROM items ORDER BY id ASC');
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Admin Panel: Manage Items</h2>
<p><a href="admin_add_item.php" class="btn btn-success">Add New Item</a></p>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th><th>Name</th><th>Price</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($items as $item): ?>
    <tr>
      <td><?= htmlspecialchars($item['id']) ?></td>
      <td><?= htmlspecialchars($item['name']) ?></td>
      <td>₹<?= number_format($item['price'],2) ?></td>
      <td>
        <a href="admin_edit_item.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
        <a href="admin_delete_item.php?id=<?= $item['id'] ?>"
           class="btn btn-sm btn-danger"
           onclick="return confirm('Delete this item?');"
        >Delete</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include __DIR__ . '/footer.php'; ?>
