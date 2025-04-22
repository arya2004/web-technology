<?php

require 'config.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT p.*, u.username AS farmer FROM products p JOIN users u ON p.user_id=u.id WHERE p.id = ?");
$stmt->execute([$id]);
$prod = $stmt->fetch();

if (!$prod) { echo "prod not found"; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare("SELECT id FROM carts WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $cart = $stmt->fetchColumn();

    if (!$cart) {
        $pdo->prepare("INSERT INTO carts (user_id) VALUES (?)")->execute([$_SESSION['user_id']]);
        $cart = $pdo->lastInsertId();
    }

    //add item
    $stmt = $pdo->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, 1)");
    $stmt->execute([$cart, $id]);
    header('Location: cart.php');
    exit;

}

?>

<h2><?= htmlspecialchars($prod['name']) ?></h2>
<p><?= nl2br(htmlspecialchars($prod['description'])) ?></p>
<p>Price: ₹<?= number_format($prod['price'],2) ?></p>
<p>Seller: <?= htmlspecialchars($prod['farmer']) ?></p>



<form method="post">
  <button>Add to Cart</button>
</form>