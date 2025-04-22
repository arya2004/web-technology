<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT c.id AS cart_id FROM carts c WHERE c.user_id = ?");
$stmt->execute([$user]);
$cart_id = $stmt->fetchColumn();

$items = [];

if ($cart_id) {
    $stmt = $pdo->prepare("
        SELECT ci.id, p.name, p.price, ci.quantity
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.id
        WHERE ci.cart_id = ?");
    $stmt->execute([$cart_id]);
    $items = $stmt->fetchAll();
}

$total = array_reduce($items, fn($sum, $i) => $sum + $i['price'] * $i['quantity'], 0);
$loggedIn = isset($_SESSION['user_id']);
$isFarmer = $loggedIn && $_SESSION['is_farmer'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - Agri Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Agri Shop</a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <?php if ($loggedIn): ?>
                    <?php if ($isFarmer): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="add_product.php">Add Product</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="card shadow p-4">
        <h3 class="mb-4">Your Shopping Cart</h3>

        <?php if (empty($items)): ?>
            <div class="alert alert-warning">Your cart is empty.</div>
            <a href="index.php" class="btn btn-outline-success">Back to Shop</a>
        <?php else: ?>
            <ul class="list-group mb-3">
                <?php foreach ($items as $it): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <?= htmlspecialchars($it['name']) ?> × <?= $it['quantity'] ?>
                        </div>
                        <span>₹ <?= number_format($it['price'] * $it['quantity'], 2) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>

            <p class="fs-5"><strong>Total: ₹ <?= number_format($total, 2) ?></strong></p>

            <a href="checkout.php" class="btn btn-primary w-100">Proceed to Checkout</a>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
