</main>
<footer class="site-footer" role="contentinfo">
<div class="container">
<div class="footer-grid">
<div class="footer-brand">
<a class="logo" href="<?= url('index.php') ?>">
<span class="logo-mark" aria-hidden="true"><img src="<?= url('images/logo-mandala.svg') ?>" alt="" style="width:100%;height:100%;display:block;"></span>
<span class="logo-text">Handicraft Nepal</span>
</a>
<p>Authentic handmade products from Nepal, including singing bowls, textiles, felt crafts, jewellery, statues, pottery and artisan décor.</p>
<p class="footer-note">Handmade gifts, home décor and cultural pieces selected with care.</p>
</div>
<div class="footer-col">
<h4>Shop</h4>
<ul>
<li><a href="<?= url('products.php') ?>">All Products</a></li>
<li><a href="<?= url('products.php?category=1') ?>">Meditation</a></li>
<li><a href="<?= url('products.php?category=2') ?>">Textiles</a></li>
<li><a href="<?= url('cart.php') ?>">Cart</a></li>
</ul>
</div>
<div class="footer-col">
<h4>Help</h4>
<ul>
<li><a href="<?= url('contact.php') ?>">Contact</a></li>
<li><a href="<?= url('privacy.php') ?>">Privacy Policy</a></li>
<li><a href="<?= url('about.php') ?>">About Us</a></li>
<li><a href="<?= url('testimonials.php') ?>">Reviews</a></li>
</ul>
</div>
<div class="footer-col">
<h4>Customer Care</h4>
<ul>
<li>Product enquiries</li>
<li>Order support</li>
<li>Shipping assistance</li>
<li>Custom craft requests</li>
</ul>
</div>
</div>
<p class="small-text">&copy; <?= date('Y') ?> Handicraft Nepal Online Store. All rights reserved.</p>
</div>
</footer>
<script src="<?= url('js/main.js') ?>"></script>
<script src="<?= url('js/form.js') ?>"></script>
</body>
</html>
