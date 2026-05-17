<?php
require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM orders WHERE order_id=? AND user_id=?');
$stmt->execute([$id, $_SESSION['user_id']]);
$order = $stmt->fetch();
if (!$order && is_admin()) { $stmt = $pdo->prepare('SELECT * FROM orders WHERE order_id=?'); $stmt->execute([$id]); $order = $stmt->fetch(); }
if (!$order) { http_response_code(404); die('Order not found.'); }
$itemStmt = $pdo->prepare('SELECT * FROM order_items WHERE order_id=?'); $itemStmt->execute([$id]); $items = $itemStmt->fetchAll();
$pageTitle = 'Order Success — Handicraft Nepal Online Store';
require __DIR__ . '/includes/header.php';
?>
<section class="page-header"><div class="container"><h1>Order confirmed</h1><p>Thank you. Your order has been received successfully.</p></div></section>
<section class="section"><div class="container"><div class="auth-card"><h2>Order #<?= (int)$order['order_id'] ?></h2><p><strong>Status:</strong> <span class="badge green"><?= e($order['status']) ?></span></p><p><strong>Total:</strong> <?= aud($order['total_amount']) ?></p><h3>Items</h3><ul class="order-items"><?php foreach($items as $item): ?><li><?= e($item['product_name']) ?> × <?= (int)$item['quantity'] ?> — <?= aud($item['line_total']) ?></li><?php endforeach; ?></ul><div class="form-actions"><a class="btn btn-primary" href="<?= url('my_orders.php') ?>">View my orders</a><a class="btn btn-ghost" href="<?= url('products.php') ?>">Continue shopping</a></div></div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
