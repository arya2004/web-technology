<?php
require_once __DIR__ . '/config.php';
include __DIR__ . '/header.php';
?>

<div class="text-center">
  <h1>Welcome to the Online Grocery Shop</h1>
  <p class="lead">
    Please <?php if (!isLoggedIn()): ?>
      <a href="login.php">Login</a> or <a href="register.php">Register</a>
    <?php else: ?>
      go to <a href="catalogue.php">Catalogue</a>
    <?php endif; ?> to continue.
  </p>
</div>

<?php include __DIR__ . '/footer.php'; ?>
