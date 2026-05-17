<?php
require_once __DIR__ . '/../includes/admin_check.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
$pageTitle = 'Admin Dashboard — Handicraft Nepal';
$counts = [
'products' => $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn(),
'orders' => $pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn(),
'users' => $pdo->query("SELECT COUNT(*) FROM users WHERE role='customer'")->fetchColumn(),
'messages' => $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status='New'")->fetchColumn(),
];
$recentOrders = $pdo->query('SELECT * FROM orders ORDER BY created_at DESC LIMIT 5')->fetchAll();
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/_admin_nav.php';
?>
<section class="page-header"><div class="container"><h1>Admin dashboard</h1><p>Manage store content, customer orders and contact messages.</p></div></section>
<section class="section"><div class="container">
<div class="stats-grid">
<div class="stat-card"><strong><?= (int)$counts['products'] ?></strong><span>Products</span></div>
<div class="stat-card"><strong><?= (int)$counts['orders'] ?></strong><span>Orders</span></div>
<div class="stat-card"><strong><?= (int)$counts['users'] ?></strong><span>Customers</span></div>
<div class="stat-card"><strong><?= (int)$counts['messages'] ?></strong><span>New messages</span></div>
</div>
<div class="table-card" style="margin-top:2rem;"><h2>Recent orders</h2><div class="table-scroll"><table class="admin-table"><thead><tr><th>Order</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th></tr></thead><tbody><?php foreach($recentOrders as $order): ?><tr><td>#<?= (int)$order['order_id'] ?></td><td><?= e($order['customer_name']) ?></td><td><?= aud($order['total_amount']) ?></td><td><span class="badge green"><?= e($order['status']) ?></span></td><td><?= e($order['created_at']) ?></td></tr><?php endforeach; ?></tbody></table></div></div>
</div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
