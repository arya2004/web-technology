<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT id FROM carts WHERE user_id = ?");
$stmt->execute([$user]);
$cart_id = $stmt->fetchColumn();

if (!$cart_id) {
    echo "<!DOCTYPE html><html><body><h3>No items in cart to checkout.</h3></body></html>";
    exit;
}

$stmt = $pdo->prepare("
    SELECT ci.product_id, p.price, ci.quantity
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.id
    WHERE ci.cart_id = ?");
$stmt->execute([$cart_id]);
$items = $stmt->fetchAll();

$total = array_reduce($items, fn($s, $i) => $s + $i['price'] * $i['quantity'], 0);

// Process order
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Agri Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Agri Shop</a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="alert alert-success shadow text-center p-4">
        <h4 class="alert-heading">Order Placed Successfully!</h4>
        <p>Thank you for your purchase. Your order <strong>#<?= $order_id ?></strong> has been placed.</p>
        <hr>
        <p class="mb-0 fs-5">Total: ₹<?= number_format($total, 2) ?></p>
    </div>

    <div class="text-center">
        <a href="index.php" class="btn btn-outline-success">Continue Shopping</a>
    </div>
</div>

</body>
</html>
