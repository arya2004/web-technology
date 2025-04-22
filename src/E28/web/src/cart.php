<?php

require 'config.php';
$user = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT c.id AS cart_id FROM carts c WHERE c.user_id = ?")
$stmt->execite([$user]);
$cart_id = $stmt->fetchColumn();

$items = [];

if($cart_id) {
    $stmt = $pdo->prepare("
    SELECT ci.id, p.name, p.price, ci.quantity
    FROM cart_items ci
    JOIN products p ON ci.pproduct_id = p.id
    WHERE ci.cart_id = ?");
    $stmt->execute([$cart_id]);
    $items = $stmt->fetchAll();
}

$total = array_reduce($items, fn($sum, $i)=>$sum + $i['price'] *$i['quantity'], 0);

?>

<a href="index.php">back to shop</a>
<h1>cart</h1>

<?php if (empty($items)): ?>
    empty cart.
<?php else: ?>
    <ul>
        <?php foreach($items as $it): ?>
            <li>
                <?= htmlspecialchars($it['name']) ?> x <?= $it['quantity'] ?> @ $ <?= number_format($it['price'], 2) ?>
            </li>
        <?php endforeach; ?>

    </ul>
    <p>
        <strong>total: $ <?= number_format($total, 2) ?> </strong>
    </p>

    <a href="checkout.php">checkout</a>
<?php endif; ?>