<?php

require 'config.php';

$stmt = $pdo->query("SELECT p.*, u.username AS farmer FROM products p JOIN users u ON p.user_id=u.id ORDER BY p.created_at DESC");
$products = $stmt->fetchAll();
?>

<a href="logout.php"> logout</a>   
<?php if($_SESSION['is_farmer']) : ?>
    <a href="add_product.php"> Add new</a>
<?php endif; ?>

<h1>Available products</h1>
<ul>

<?php foreach($products as $prod): ?>
    <li>

    <a href="view_product.php?id=<?= $prod['id'] ?>">

    <?= htmlspecialchars($prod['name']) ?>

    </a>

    - $ <?= number_format($prod['price'], 2) ?> by <?= htmlspecialchars($prod['farmer']) ?>

    </li>

<?php endforeach; ?>

</ul>