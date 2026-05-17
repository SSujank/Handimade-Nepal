<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Customer Reviews — Handicraft Nepal Online Store';
$pageDescription = 'Read customer testimonials from Handicraft Nepal shoppers.';
$active = 'reviews';
$reviews = $pdo->query('SELECT * FROM testimonials WHERE is_approved=1 ORDER BY created_at DESC')->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="page-header"><div class="container"><h1>Customer reviews</h1><p>Read feedback from customers who enjoy handmade Nepali craft products.</p></div></section>
<section class="section"><div class="container"><div class="values-grid"><?php foreach($reviews as $review): ?><article class="value-card"><div class="value-icon" aria-hidden="true">★</div><h3><?= e($review['customer_name']) ?></h3><p><strong><?= str_repeat('★', (int)$review['rating']) ?></strong></p><p><?= e($review['comment']) ?></p><p class="small-text"><?= e($review['location']) ?></p></article><?php endforeach; ?></div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
