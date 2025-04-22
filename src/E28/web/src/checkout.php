<?php
require 'config.php';
$user = $_SESSION['user_id'];


$stmt = $pdo->prepare("SELECT id FROM carts WHERE user_id = ?");
$stmt->execute([$user]);
$cart_id = $stmt->fetchColumn();

if (!$cart_id) {
    echo "Nothing to checkout.";
    exit;
}
$stmt = $pdo->prepare("
  SELECT ci.product_id, p.price, ci.quantity
  FROM cart_items ci
  JOIN products p ON ci.product_id = p.id
  WHERE ci.cart_id = ?");
$stmt->execute([$cart_id]);
$items = $stmt->fetchAll();

$total = array_reduce($items, fn($s,$i)=>$s + $i['price']*$i['quantity'], 0);


$pdo->beginTransaction();
$stmt = $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
$stmt->execute([$user, $total]);
$order_id = $pdo->lastInsertId();

$stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
foreach ($items as $it) {
    $stmt->execute([$order_id, $it['product_id'], $it['quantity'], $it['price']]);
}

$pdo->prepare("DELETE FROM cart_items WHERE cart_id = ?")->execute([$cart_id]);
$pdo->commit();

echo "Order #{$order_id} placed! Total $" . number_format($total,2);
