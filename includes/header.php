<?php
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? SITE_NAME;
$pageDescription = $pageDescription ?? 'Shop authentic handmade Nepali crafts including singing bowls, thangka art, Buddha statues, pashmina, Dhaka textiles, jewellery and fair-trade gifts.';
$active = $active ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?= e($pageDescription) ?>">
<meta name="keywords" content="Nepal handicrafts, handmade crafts, singing bowl, thangka, pashmina, Buddha statue, fair trade Nepal, online craft store">
<meta name="author" content="Handicraft Nepal Online Store">
<title><?= e($pageTitle) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= url('css/style.css') ?>">
<link rel="icon" href="<?= url('images/logo-mandala.svg') ?>" type="image/svg+xml">
</head>
<body>
<a class="skip-link" href="#main">Skip to main content</a>
<header class="site-header" role="banner">
<div class="container">
<nav class="nav-wrapper" aria-label="Main navigation">
<a class="logo" href="<?= url('index.php') ?>" aria-label="<?= e(SITE_NAME) ?> home">
<span class="logo-mark" aria-hidden="true"><img src="<?= url('images/logo-mandala.svg') ?>" alt="" style="width:100%;height:100%;display:block;"></span>
<span class="logo-copy"><span class="logo-text">Handicraft Nepal</span><span class="logo-subtitle">Authentic Handmade Treasures</span></span>
</a>
<button class="menu-toggle" aria-controls="primary-nav" aria-expanded="false" aria-label="Toggle menu">☰</button>
<ul class="nav-list" id="primary-nav">
<li><a class="<?= $active==='home'?'active':'' ?>" href="<?= url('index.php') ?>">Home</a></li>
<li><a class="<?= $active==='about'?'active':'' ?>" href="<?= url('about.php') ?>">About</a></li>
<li><a class="<?= $active==='products'?'active':'' ?>" href="<?= url('products.php') ?>">Products</a></li>
<li><a class="<?= $active==='gallery'?'active':'' ?>" href="<?= url('gallery.php') ?>">Gallery</a></li>
<li><a class="<?= $active==='reviews'?'active':'' ?>" href="<?= url('testimonials.php') ?>">Reviews</a></li>
<li><a class="<?= $active==='contact'?'active':'' ?>" href="<?= url('contact.php') ?>">Contact</a></li>
<li><a href="<?= url('cart.php') ?>">Cart (<?= cart_count() ?>)</a></li>
<?php if (is_logged_in()): ?>
    <?php if (is_admin()): ?>
        <li><a href="<?= url('admin/dashboard.php') ?>">Admin</a></li>
        <li><a href="<?= url('logout.php') ?>">Logout</a></li>
    <?php else: ?>
        <li><a href="<?= url('my_orders.php') ?>">My Orders</a></li>
        <li><a href="<?= url('logout.php') ?>">Logout</a></li>
    <?php endif; ?>
<?php else: ?>
    <li><a href="<?= url('login.php') ?>">Login</a></li>
<?php endif; ?>
</ul>
</nav>
</div>
</header>
<main id="main">
<?php $flashHtml = flash_message(); if ($flashHtml): ?>
<div class="container"><?= $flashHtml ?></div>
<?php endif; ?>
