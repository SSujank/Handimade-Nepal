<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT p.*, c.category_name FROM products p JOIN categories c ON p.category_id=c.category_id WHERE p.product_id=? AND p.is_active=1');
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) { http_response_code(404); die('Product not found.'); }
$pageTitle = e($product['product_name']) . ' — Handicraft Nepal Online Store';
$pageDescription = substr(strip_tags($product['description']), 0, 150);
$active = 'products';
require __DIR__ . '/includes/header.php';
?>
<section class="page-header"><div class="container"><h1><?= e($product['product_name']) ?></h1><p><?= e($product['category_name']) ?> · <?= aud($product['price']) ?></p></div></section>
<section class="section"><div class="container"><div class="story-grid">
<div class="story-image"><img src="<?= e($product['image_url']) ?>" alt="<?= e($product['product_name']) ?>"></div>
<div class="story-content">
<span class="eyebrow" style="color:var(--clr-terracotta);font-size:.8rem;font-weight:700;letter-spacing:.25em;text-transform:uppercase;"><?= e($product['category_name']) ?></span>
<h2><?= e($product['product_name']) ?></h2>
<p><?= e($product['description']) ?></p>
<p><strong>Price:</strong> <?= aud($product['price']) ?> &nbsp; <strong>Available stock:</strong> <?= (int)$product['stock'] ?></p>
<form method="get" action="<?= url('cart.php') ?>" class="product-actions">
<input type="hidden" name="action" value="add"><input type="hidden" name="id" value="<?= (int)$product['product_id'] ?>">
<label for="qty"><strong>Quantity</strong></label><input class="qty-input" id="qty" type="number" name="qty" min="1" max="<?= max(1,(int)$product['stock']) ?>" value="1">
<button class="btn btn-primary" type="submit">Add to cart</button>
<a class="btn btn-ghost" href="<?= url('products.php') ?>">Back to products</a>
</form>
<div class="privacy-box"><strong>Handmade note:</strong> Each handmade item may have small variations in colour, texture or finish. These natural differences make every piece unique.</div>
</div>
</div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
