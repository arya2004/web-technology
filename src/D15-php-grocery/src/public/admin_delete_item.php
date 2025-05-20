<?php
require_once __DIR__ . '/config.php';
requireAuth();
if (currentUserRole() !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    echo "Access denied.";
    exit;
}

$id = $_GET['id'] ?? null;
if ($id && is_numeric($id)) {
    $del = $pdo->prepare('DELETE FROM items WHERE id = ?');
    $del->execute([$id]);
}

header('Location: admin_items.php');
exit;
