<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Gallery — Handicraft Nepal Online Store';
$pageDescription = 'View gallery images of Nepali handmade products, textiles, decor and artisan craft inspiration.';
$active = 'gallery';
require __DIR__ . '/includes/header.php';
$images = [
    ['Meditation craft','images/products/singing_bowl_final.png'],
    ['Nepali textile','images/products/dhaka_topi_scarf_set_final.png'],
    ['Felt decor','images/products/felt_ball_garland_final.png'],
    ['Traditional art','images/products/thangka_wall_painting_final.png'],
    ['Clay pottery','images/products/clay_tea_cup_set_final.png'],
    ['Cultural decor','images/products/traditional_wooden_mask_final.png']
];
?>
<section class="page-header"><div class="container"><h1>Gallery</h1><p>A visual collection of handmade craft inspiration, product materials and Nepali cultural design.</p></div></section>
<section class="section"><div class="container"><div class="product-grid">
<?php foreach($images as $img): ?>
<article class="product-card">
<div class="product-image"><img src="<?= e($img[1]) ?>" alt="<?= e($img[0]) ?>"></div>
<div class="product-body"><h3 class="product-name"><?= e($img[0]) ?></h3><p class="product-desc">Image used to support the visual media and cultural craft theme of the website.</p></div>
</article>
<?php endforeach; ?>
</div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
