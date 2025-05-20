<?php
require_once __DIR__ . '/config.php';
requireAuth();

include __DIR__ . '/header.php';

// Fetch items
$stmt = $pdo->query('SELECT * FROM items ORDER BY id ASC');
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Catalogue</h2>

<div class="row">
  <?php foreach ($items as $item): ?>
    <div class="col-md-4 mb-4">
      <div class="card h-100">
        <?php if ($item['image_url']): ?>
          <img src="<?= htmlspecialchars($item['image_url']) ?>"
               class="card-img-top"
               alt="<?= htmlspecialchars($item['name']) ?>">
        <?php endif; ?>
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
          <p class="card-text"><?= nl2br(htmlspecialchars($item['description'])) ?></p>
        </div>
        <div class="card-footer">
          <strong>₹<?= number_format($item['price'], 2) ?></strong>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
