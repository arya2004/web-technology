<?php
require 'config.php';

$stmt = $pdo->query("SELECT p.*, u.username AS farmer FROM products p JOIN users u ON p.user_id=u.id ORDER BY p.created_at DESC");
$products = $stmt->fetchAll();
$loggedIn = isset($_SESSION['user_id']);
$isFarmer = $loggedIn && $_SESSION['is_farmer'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agri Shop - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Agri Shop</a>
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
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart</a>
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
    <h2 class="mb-4">Available Products</h2>

    <div class="row">
        <?php foreach ($products as $prod): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="view_product.php?id=<?= $prod['id'] ?>" class="text-decoration-none">
                                <?= htmlspecialchars($prod['name']) ?>
                            </a>
                        </h5>
                        <p class="card-text">₹ <?= number_format($prod['price'], 2) ?></p>
                        <p class="text-muted mb-0">by <strong><?= htmlspecialchars($prod['farmer']) ?></strong></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
