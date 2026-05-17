<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Handicraft Nepal Online Store — Authentic Handmade Treasures';
$pageDescription = 'Authentic handmade Nepali handicrafts, fair-trade inspired gifts, home decor, textiles, art and meditation products.';
$active = 'home';
$stmt = $pdo->query("SELECT p.*, c.category_name FROM products p JOIN categories c ON p.category_id=c.category_id WHERE p.is_active=1 AND p.is_featured=1 ORDER BY p.created_at DESC LIMIT 4");
$featured = $stmt->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="hero" aria-labelledby="hero-heading">
<div class="container">
<div class="hero-grid">
<div class="hero-content fade-in">
<span class="hero-tagline">Fair Trade Inspired · Handmade in Nepal</span>
<h1 id="hero-heading">Soul of the <span class="accent">Himalayas</span>, handmade for your home.</h1>
<p class="lead">Handicraft Nepal Online Store connects customers with authentic handmade products from Kathmandu, Patan, Bhaktapur and Pokhara. Browse artisan products, create an account, place orders and contact our team with any product or shipping questions.</p>
<div class="hero-cta-row">
<a class="btn btn-primary" href="<?= url('products.php') ?>">Shop the collection</a>
<a class="btn btn-ghost" href="<?= url('about.php') ?>">Our story</a>
</div>
</div>
<div class="hero-visual fade-in fade-in--delay-2" aria-hidden="true">
<div class="hero-tile hero-tile--1" style="background-image:url('images/products/bronze_buddha_statue_final.png');"></div>
<div class="hero-tile hero-tile--2" style="background-image:url('images/products/clay_tea_cup_set_final.png');"></div>
<div class="hero-tile hero-tile--3">Namaste from Nepal.</div>
<div class="hero-tile hero-tile--4" style="background-image:url('images/products/felt_ball_garland_final.png');"></div>
<div class="hero-tile hero-tile--5" style="background-image:url('images/products/dhaka_topi_scarf_set_final.png');"></div>
</div>
</div>
</div>
</section>

<section class="section observe" aria-labelledby="featured-heading">
<div class="container">
<div class="section-heading">
<span class="eyebrow">Featured collection</span>
<h2 id="featured-heading">Featured handicrafts</h2>
<p class="lead" style="margin:0 auto;">Explore popular handmade pieces selected for home styling, gifting and mindful everyday use.</p>
</div>
<div class="product-grid">
<?php foreach ($featured as $product): ?>
<article class="product-card">
<div class="product-image"><img src="<?= e($product['image_url']) ?>" alt="<?= e($product['product_name']) ?>"></div>
<div class="product-body">
<span class="product-category"><?= e($product['category_name']) ?></span>
<h3 class="product-name"><?= e($product['product_name']) ?></h3>
<p class="product-desc"><?= e($product['description']) ?></p>
<div class="product-footer">
<span class="product-price"><strong><?= aud($product['price']) ?></strong><small>Stock: <?= (int)$product['stock'] ?></small></span>
<span class="product-badge">Featured</span>
</div>
<div class="product-actions">
<a class="btn btn-primary" href="<?= url('product.php?id=' . (int)$product['product_id']) ?>">View product</a>
<a class="btn btn-ghost" href="<?= url('cart.php?action=add&id=' . (int)$product['product_id']) ?>">Add to cart</a>
</div>
</div>
</article>
<?php endforeach; ?>
</div>
</div>
</section>

<section class="section story-section observe" aria-labelledby="system-heading">
<div class="container">
<div class="story-grid">
<div class="story-image"><img src="images/products/bronze_buddha_statue_final.png" alt="Bronze Buddha statue product image"></div>
<div class="story-content">
<span class="eyebrow" style="color:var(--clr-terracotta);font-size:.8rem;font-weight:700;letter-spacing:.25em;text-transform:uppercase;">Our craft promise</span>
<h2 id="system-heading">Handmade pieces with a story.</h2>
<p>Every product is selected to reflect Nepali craft culture, warm natural materials and thoughtful design for modern homes.</p>
<p>Customers can browse the collection, create an account, place orders, review order history and contact the store for product or shipping support.</p>
<a class="btn btn-primary" href="<?= url('register.php') ?>" style="margin-top:1rem;">Create account</a>
</div>
</div>
</div>
</section>

<section class="section observe" aria-labelledby="values-heading">
<div class="container">
<div class="section-heading">
<span class="eyebrow">Store values</span>
<h2 id="values-heading">Simple shopping, privacy and customer care</h2>
</div>
<div class="values-grid">
<div class="value-card"><div class="value-icon" aria-hidden="true">🔐</div><h3>Secure accounts</h3><p>Customer accounts help keep order details organised and accessible after checkout.</p></div>
<div class="value-card"><div class="value-icon" aria-hidden="true">✅</div><h3>Clear checkout</h3><p>Forms are checked carefully so customers can submit correct details with fewer errors.</p></div>
<div class="value-card"><div class="value-icon" aria-hidden="true">🌐</div><h3>Easy browsing</h3><p>Readable pages, clear product images and helpful navigation make the store simple to use.</p></div>
</div>
</div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
