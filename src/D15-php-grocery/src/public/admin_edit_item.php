<?php
require_once __DIR__ . '/config.php';
requireAuth();
if (currentUserRole() !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    echo "Access denied.";
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header('Location: admin_items.php');
    exit;
}

// Fetch existing
$stmt = $pdo->prepare('SELECT * FROM items WHERE id = ?');
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$item) {
    header('Location: admin_items.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = $_POST['price'] ?? '';
    $image_url   = trim($_POST['image_url'] ?? '');

    if (!$name || !$price || !is_numeric($price)) {
        $error = 'Name and valid price are required.';
    } else {
        $upd = $pdo->prepare(
          'UPDATE items SET name=?, description=?, price=?, image_url=? WHERE id=?'
        );
        $upd->execute([$name, $description, $price, $image_url, $id]);
        header('Location: admin_items.php');
        exit;
    }
}

include __DIR__ . '/header.php';
?>

<h2>Edit Item #<?= htmlspecialchars($item['id']) ?></h2>
<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input name="name" type="text" class="form-control"
           value="<?= htmlspecialchars($_POST['name'] ?? $item['name']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control"><?= htmlspecialchars($_POST['description'] ?? $item['description']) ?></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Price</label>
    <input name="price" type="text" class="form-control"
           value="<?= htmlspecialchars($_POST['price'] ?? $item['price']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Image URL</label>
    <input name="image_url" type="text" class="form-control"
           value="<?= htmlspecialchars($_POST['image_url'] ?? $item['image_url']) ?>">
  </div>
  <button class="btn btn-primary" type="submit">Update Item</button>
  <a href="admin_items.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include __DIR__ . '/footer.php'; ?>
