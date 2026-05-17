<?php
require_once __DIR__ . '/../includes/admin_check.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
$users=$pdo->query('SELECT user_id, full_name, email, role, phone, address, created_at FROM users ORDER BY created_at DESC')->fetchAll();
$pageTitle='Manage Users — Admin';
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/_admin_nav.php';
?>
<section class="page-header"><div class="container"><h1>Manage users</h1><p>View registered customers and admin accounts.</p></div></section>
<section class="section"><div class="container"><div class="table-card"><div class="table-scroll"><table class="admin-table"><thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Phone</th><th>Address</th><th>Created</th></tr></thead><tbody><?php foreach($users as $u): ?><tr><td><?= e($u['full_name']) ?></td><td><?= e($u['email']) ?></td><td><span class="badge <?= $u['role']==='admin'?'red':'green' ?>"><?= e($u['role']) ?></span></td><td><?= e($u['phone']) ?></td><td><?= e($u['address']) ?></td><td><?= e($u['created_at']) ?></td></tr><?php endforeach; ?></tbody></table></div></div></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
