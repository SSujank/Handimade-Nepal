<?php
require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$stmt = $pdo->prepare('SELECT * FROM orders WHERE user_id=? ORDER BY created_at DESC');
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll();
$pageTitle = 'My Orders — Handicraft Nepal Online Store';
require __DIR__ . '/includes/header.php';
?>
<section class="page-header"><div class="container"><h1>My orders</h1><p>Track orders placed through your customer account.</p></div></section>
<section class="section"><div class="container"><div class="table-card">
<?php if(!$orders): ?><p>You have not placed any orders yet.</p><a class="btn btn-primary" href="<?= url('products.php') ?>">Shop now</a><?php else: ?><div class="table-scroll"><table class="admin-table"><thead><tr><th>Order</th><th>Date</th><th>Total</th><th>Status</th><th>View</th></tr></thead><tbody><?php foreach($orders as $order): ?><tr><td>#<?= (int)$order['order_id'] ?></td><td><?= e($order['created_at']) ?></td><td><?= aud($order['total_amount']) ?></td><td><span class="badge green"><?= e($order['status']) ?></span></td><td><a href="<?= url('order_success.php?id='.(int)$order['order_id']) ?>">View</a></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?>
</div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
