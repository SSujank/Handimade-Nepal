<?php
require_once __DIR__ . '/../includes/admin_check.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
$products = $pdo->query('SELECT p.*, c.category_name FROM products p JOIN categories c ON p.category_id=c.category_id ORDER BY p.product_id DESC')->fetchAll();
$pageTitle = 'Manage Products — Admin';
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/_admin_nav.php';
?>
<section class="page-header"><div class="container"><h1>Manage products</h1><p>Add, edit, deactivate and delete products shown in the online store.</p></div></section>
<section class="section"><div class="container"><div class="form-actions"><a class="btn btn-primary" href="<?= url('admin/product_form.php') ?>">Add new product</a></div><div class="table-card"><div class="table-scroll"><table class="admin-table"><thead><tr><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr></thead><tbody>
<?php foreach($products as $p): ?><tr><td><img src="<?= e($p['image_url']) ?>" alt="<?= e($p['product_name']) ?>"></td><td><strong><?= e($p['product_name']) ?></strong><br><span class="small-text"><?= e(substr($p['description'],0,80)) ?>...</span></td><td><?= e($p['category_name']) ?></td><td><?= aud($p['price']) ?></td><td><?= (int)$p['stock'] ?></td><td><?= $p['is_active'] ? '<span class="badge green">Active</span>' : '<span class="badge red">Inactive</span>' ?></td><td><a href="<?= url('admin/product_form.php?id='.(int)$p['product_id']) ?>">Edit</a> | <a href="<?= url('admin/delete_product.php?id='.(int)$p['product_id']) ?>" onclick="return confirm('Delete this product?')">Delete</a></td></tr><?php endforeach; ?>
</tbody></table></div></div></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
