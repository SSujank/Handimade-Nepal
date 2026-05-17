<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Products — Handicraft Nepal Online Store';
$pageDescription = 'Browse handmade Nepali products including singing bowls, pashmina, Buddha statues, felt decor, jewellery and handmade art.';
$active = 'products';
$categoryId = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$search = trim($_GET['search'] ?? '');
$categories = $pdo->query('SELECT * FROM categories ORDER BY category_name')->fetchAll();
$sql = "SELECT p.*, c.category_name FROM products p JOIN categories c ON p.category_id=c.category_id WHERE p.is_active=1";
$params = [];
if ($categoryId > 0) { $sql .= " AND p.category_id=?"; $params[] = $categoryId; }
if ($search !== '') { $sql .= " AND (p.product_name LIKE ? OR p.description LIKE ? OR c.category_name LIKE ?)"; $term = "%$search%"; $params = array_merge($params, [$term,$term,$term]); }
$sql .= " ORDER BY p.is_featured DESC, p.product_name";
$stmt = $pdo->prepare($sql); $stmt->execute($params); $products = $stmt->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="page-header"><div class="container"><h1>Shop handmade products</h1><p>Explore authentic Nepali handicrafts for home decor, gifting, meditation and everyday use.</p></div></section>
<section class="section"><div class="container">
<form class="filters" method="get" action="<?= url('products.php') ?>" aria-label="Product filter">
<div class="form-field"><label for="category">Category</label><select id="category" name="category"><option value="0">All categories</option><?php foreach($categories as $cat): ?><option value="<?= (int)$cat['category_id'] ?>" <?= $categoryId===(int)$cat['category_id']?'selected':'' ?>><?= e($cat['category_name']) ?></option><?php endforeach; ?></select></div>
<div class="form-field"><label for="search">Search</label><input id="search" name="search" type="search" placeholder="Search products..." value="<?= e($search) ?>"></div>
<div class="form-actions"><button class="btn btn-primary" type="submit">Apply filter</button><a class="btn btn-ghost" href="<?= url('products.php') ?>">Reset</a></div>
</form>
<?php if (!$products): ?><div class="search-empty"><h2>No products found</h2><p>Try a different search or category.</p></div><?php endif; ?>
<div class="product-grid">
<?php foreach($products as $product): ?>
<article class="product-card">
<div class="product-image"><img src="<?= e($product['image_url']) ?>" alt="<?= e($product['product_name']) ?>"></div>
<div class="product-body">
<span class="product-category"><?= e($product['category_name']) ?></span>
<h3 class="product-name"><?= e($product['product_name']) ?></h3>
<p class="product-desc"><?= e($product['description']) ?></p>
<div class="product-footer"><span class="product-price"><strong><?= aud($product['price']) ?></strong><small>Stock: <?= (int)$product['stock'] ?></small></span><?php if($product['is_featured']): ?><span class="product-badge">Featured</span><?php endif; ?></div>
<div class="product-actions"><a class="btn btn-primary" href="<?= url('product.php?id='.(int)$product['product_id']) ?>">View</a><a class="btn btn-ghost" href="<?= url('cart.php?action=add&id='.(int)$product['product_id']) ?>">Add to cart</a></div>
</div>
</article>
<?php endforeach; ?>
</div>
</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
