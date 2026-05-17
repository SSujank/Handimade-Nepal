<?php
require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
if (empty($_SESSION['cart'])) { set_flash('error', 'Your cart is empty.'); redirect('cart.php'); }
$userStmt = $pdo->prepare('SELECT * FROM users WHERE user_id=?');
$userStmt->execute([$_SESSION['user_id']]);
$user = $userStmt->fetch();
$ids = array_map('intval', array_keys($_SESSION['cart']));
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT * FROM products WHERE product_id IN ($placeholders) AND is_active=1");
$stmt->execute($ids);
$products = $stmt->fetchAll();
$items = []; $total = 0; $errors = [];
foreach($products as $product) {
    $qty = min((int)$_SESSION['cart'][$product['product_id']], (int)$product['stock']);
    if ($qty > 0) { $line = $qty * (float)$product['price']; $items[] = ['product'=>$product,'qty'=>$qty,'line'=>$line]; $total += $line; }
}
if (!$items) { set_flash('error', 'No available items in cart.'); redirect('cart.php'); }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['customer_name'] ?? '');
    $email = trim($_POST['customer_email'] ?? '');
    $phone = trim($_POST['customer_phone'] ?? '');
    $address = trim($_POST['shipping_address'] ?? '');
    $notes = trim($_POST['notes'] ?? '');
    $consent = isset($_POST['consent']);
    if (strlen($name) < 2) $errors[] = 'Name must be at least 2 characters.';
    if (!validate_email($email)) $errors[] = 'Valid email is required.';
    if (strlen($phone) < 8) $errors[] = 'Phone number is required.';
    if (strlen($address) < 10) $errors[] = 'Shipping address must be at least 10 characters.';
    if (!$consent) $errors[] = 'You must agree to data processing for this order.';
    if (!$errors) {
        $pdo->beginTransaction();
        try {
            $orderStmt = $pdo->prepare('INSERT INTO orders (user_id, customer_name, customer_email, customer_phone, shipping_address, notes, total_amount) VALUES (?,?,?,?,?,?,?)');
            $orderStmt->execute([$_SESSION['user_id'],$name,$email,$phone,$address,$notes,$total]);
            $orderId = (int)$pdo->lastInsertId();
            $itemStmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, product_name, quantity, unit_price, line_total) VALUES (?,?,?,?,?,?)');
            $stockStmt = $pdo->prepare('UPDATE products SET stock = stock - ? WHERE product_id=? AND stock >= ?');
            foreach($items as $item) {
                $p = $item['product'];
                $itemStmt->execute([$orderId,$p['product_id'],$p['product_name'],$item['qty'],$p['price'],$item['line']]);
                $stockStmt->execute([$item['qty'],$p['product_id'],$item['qty']]);
            }
            $pdo->commit();
            $_SESSION['cart'] = [];
            set_flash('success', 'Order placed successfully. Your order ID is #' . $orderId . '.');
            redirect('order_success.php?id=' . $orderId);
        } catch (Exception $ex) {
            $pdo->rollBack();
            $errors[] = 'Could not place order. Please try again.';
        }
    }
}
$pageTitle = 'Checkout — Handicraft Nepal Online Store';
$pageDescription = 'Checkout and place your order securely.';
require __DIR__ . '/includes/header.php';
?>
<section class="page-header"><div class="container"><h1>Checkout</h1><p>Complete your order details. We collect only the information needed to process the order.</p></div></section>
<section class="section"><div class="container"><div class="story-grid">
<div class="auth-card">
<h2>Order details</h2>
<?php foreach($errors as $error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endforeach; ?>
<form method="post">
<div class="form-field"><label for="customer_name">Full name *</label><input id="customer_name" name="customer_name" type="text" required value="<?= e($_POST['customer_name'] ?? $user['full_name']) ?>"></div>
<div class="form-row"><div class="form-field"><label for="customer_email">Email *</label><input id="customer_email" name="customer_email" type="email" required value="<?= e($_POST['customer_email'] ?? $user['email']) ?>"></div><div class="form-field"><label for="customer_phone">Phone *</label><input id="customer_phone" name="customer_phone" type="tel" required value="<?= e($_POST['customer_phone'] ?? $user['phone']) ?>"></div></div>
<div class="form-field"><label for="shipping_address">Shipping address *</label><input id="shipping_address" name="shipping_address" type="text" minlength="10" required value="<?= e($_POST['shipping_address'] ?? $user['address']) ?>"></div>
<div class="form-field"><label for="notes">Order notes</label><textarea id="notes" name="notes" maxlength="1000" placeholder="Delivery instructions or product request..."><?= e($_POST['notes'] ?? '') ?></textarea></div>
<div class="checkbox-field"><input id="consent" name="consent" type="checkbox" required><label for="consent" style="margin-bottom:0;font-weight:400;">I agree for my order and contact details to be stored for processing, delivery and support. *</label></div>
<div class="form-actions"><button class="btn btn-primary" type="submit">Place order</button><a class="btn btn-ghost" href="<?= url('cart.php') ?>">Back to cart</a></div>
</form>
</div>
<aside class="auth-card"><h2>Order summary</h2><ul class="order-items"><?php foreach($items as $item): ?><li><?= e($item['product']['product_name']) ?> × <?= (int)$item['qty'] ?> — <?= aud($item['line']) ?></li><?php endforeach; ?></ul><hr><p><strong>Total: <?= aud($total) ?></strong></p><div class="privacy-box"><strong>Privacy:</strong> Data is used only for order processing, customer support and record keeping. See the Privacy Policy page for details.</div></aside>
</div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
