<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$action = $_GET['action'] ?? $_POST['action'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = []; }
if ($action === 'add' && $id > 0) {
    $qty = max(1, min(99, (int)($_GET['qty'] ?? 1)));
    $stmt = $pdo->prepare('SELECT stock, product_name FROM products WHERE product_id=? AND is_active=1');
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    if ($product && $product['stock'] > 0) {
        $_SESSION['cart'][$id] = min((int)$product['stock'], ($_SESSION['cart'][$id] ?? 0) + $qty);
        set_flash('success', $product['product_name'] . ' was added to your cart.');
    } else { set_flash('error', 'Product is not available.'); }
    redirect('cart.php');
}
if ($action === 'remove' && $id > 0) { unset($_SESSION['cart'][$id]); set_flash('info', 'Item removed from cart.'); redirect('cart.php'); }
if ($action === 'clear') { $_SESSION['cart'] = []; set_flash('info', 'Cart cleared.'); redirect('cart.php'); }
if ($action === 'update' && !empty($_POST['qty'])) {
    foreach ($_POST['qty'] as $pid => $qty) {
        $pid = (int)$pid; $qty = (int)$qty;
        if ($qty <= 0) { unset($_SESSION['cart'][$pid]); } else { $_SESSION['cart'][$pid] = min(99, $qty); }
    }
    set_flash('success', 'Cart updated.'); redirect('cart.php');
}
$items = []; $total = 0;
if (!empty($_SESSION['cart'])) {
    $ids = array_map('intval', array_keys($_SESSION['cart']));
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id IN ($placeholders) AND is_active=1");
    $stmt->execute($ids);
    foreach ($stmt->fetchAll() as $product) {
        $qty = min((int)$_SESSION['cart'][$product['product_id']], (int)$product['stock']);
        $line = $qty * (float)$product['price'];
        $items[] = ['product'=>$product, 'qty'=>$qty, 'line'=>$line];
        $total += $line;
    }
}
$pageTitle = 'Shopping Cart — Handicraft Nepal Online Store';
$pageDescription = 'Review selected handmade Nepali products before checkout.';
require __DIR__ . '/includes/header.php';
?>
<section class="page-header"><div class="container"><h1>Your cart</h1><p>Review your selected items and continue to checkout.</p></div></section>
<section class="section"><div class="container">
<?php if (!$items): ?><div class="auth-card"><h2>Your cart is empty</h2><p>Browse the product catalogue and add items to your cart.</p><a class="btn btn-primary" href="<?= url('products.php') ?>">Shop products</a></div>
<?php else: ?>
<form method="post" class="table-card"><input type="hidden" name="action" value="update"><div class="table-scroll"><table class="admin-table"><thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th></tr></thead><tbody>
<?php foreach($items as $item): $p=$item['product']; ?>
<tr><td><strong><?= e($p['product_name']) ?></strong><br><span class="small-text">Stock: <?= (int)$p['stock'] ?></span></td><td><?= aud($p['price']) ?></td><td><input class="qty-input" type="number" name="qty[<?= (int)$p['product_id'] ?>]" value="<?= (int)$item['qty'] ?>" min="0" max="<?= (int)$p['stock'] ?>"></td><td><?= aud($item['line']) ?></td><td><a href="<?= url('cart.php?action=remove&id='.(int)$p['product_id']) ?>">Remove</a></td></tr>
<?php endforeach; ?>
</tbody></table></div><div class="cart-summary"><div><strong>Cart total: <?= aud($total) ?></strong></div><div class="form-actions"><button class="btn btn-ghost" type="submit">Update cart</button><a class="btn btn-ghost" href="<?= url('cart.php?action=clear') ?>">Clear cart</a><a class="btn btn-primary" href="<?= url('checkout.php') ?>">Checkout</a></div></div></form>
<?php endif; ?>
</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
