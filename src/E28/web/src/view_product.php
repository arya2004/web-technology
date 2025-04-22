<?php
require 'config.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT p.*, u.username AS farmer FROM products p JOIN users u ON p.user_id=u.id WHERE p.id = ?");
$stmt->execute([$id]);
$prod = $stmt->fetch();

if (!$prod) {
    echo "<!DOCTYPE html><html><body><h2>Product not found</h2></body></html>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM carts WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $cart = $stmt->fetchColumn();

    if (!$cart) {
        $pdo->prepare("INSERT INTO carts (user_id) VALUES (?)")->execute([$_SESSION['user_id']]);
        $cart = $pdo->lastInsertId();
    }

    $stmt = $pdo->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, 1)");
    $stmt->execute([$cart, $id]);
    header('Location: cart.php');
    exit;
}

$loggedIn = isset($_SESSION['user_id']);
$isFarmer = $loggedIn && $_SESSION['is_farmer'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($prod['name']) ?> - Agri Shop</title>
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
                        <a class="nav-link" href="cart.php">Cart</a>
                    </li>
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
    <div class="card shadow mb-4">
        <div class="card-body">
            <h3 class="card-title"><?= htmlspecialchars($prod['name']) ?></h3>
            <p class="card-text"><?= nl2br(htmlspecialchars($prod['description'])) ?></p>
            <p class="card-text"><strong>Price:</strong> ₹<?= number_format($prod['price'], 2) ?></p>
            <p class="card-text text-muted"><strong>Seller:</strong> <?= htmlspecialchars($prod['farmer']) ?></p>

            <?php if ($loggedIn): ?>
                <form method="post">
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>
            <?php else: ?>
                <div class="alert alert-warning mt-3">Please <a href="login.php" class="alert-link">login</a> to add to cart.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
