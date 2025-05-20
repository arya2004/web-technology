<?php
require_once __DIR__ . '/config.php';
requireAuth();
if (currentUserRole() !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    echo "Access denied.";
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
        $stmt = $pdo->prepare(
          'INSERT INTO items (name, description, price, image_url) VALUES (?,?,?,?)'
        );
        $stmt->execute([$name, $description, $price, $image_url]);
        header('Location: admin_items.php');
        exit;
    }
}

include __DIR__ . '/header.php';
?>

<h2>Add New Item</h2>
<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input name="name" type="text" class="form-control"
           value="<?= htmlspecialchars($name ?? '') ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control"><?= htmlspecialchars($description ?? '') ?></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Price</label>
    <input name="price" type="text" class="form-control"
           value="<?= htmlspecialchars($price ?? '') ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Image URL</label>
    <input name="image_url" type="text" class="form-control"
           value="<?= htmlspecialchars($image_url ?? '') ?>">
  </div>
  <button class="btn btn-success" type="submit">Create Item</button>
  <a href="admin_items.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include __DIR__ . '/footer.php'; ?>
