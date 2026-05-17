<?php
require_once __DIR__ . '/../includes/admin_check.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $orderId=(int)($_POST['order_id'] ?? 0);
    $status=$_POST['status'] ?? 'Pending';
    $allowed=['Pending','Confirmed','Packed','Shipped','Delivered','Cancelled'];
    if($orderId>0 && in_array($status,$allowed,true)){
        $stmt=$pdo->prepare('UPDATE orders SET status=? WHERE order_id=?');
        $stmt->execute([$status,$orderId]);
        set_flash('success','Order status updated.');
    }
    redirect('admin/manage_orders.php');
}
$orders=$pdo->query('SELECT * FROM orders ORDER BY created_at DESC')->fetchAll();
$itemStmt=$pdo->prepare('SELECT * FROM order_items WHERE order_id=?');
$pageTitle='Manage Orders — Admin';
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/_admin_nav.php';
?>
<section class="page-header"><div class="container"><h1>Manage orders</h1><p>View customer orders and update fulfilment status.</p></div></section>
<section class="section"><div class="container"><div class="table-card"><div class="table-scroll"><table class="admin-table"><thead><tr><th>Order</th><th>Customer</th><th>Items</th><th>Total</th><th>Address</th><th>Status</th></tr></thead><tbody>
<?php foreach($orders as $order): $itemStmt->execute([$order['order_id']]); $items=$itemStmt->fetchAll(); ?>
<tr><td>#<?= (int)$order['order_id'] ?><br><span class="small-text"><?= e($order['created_at']) ?></span></td><td><?= e($order['customer_name']) ?><br><a href="mailto:<?= e($order['customer_email']) ?>"><?= e($order['customer_email']) ?></a><br><?= e($order['customer_phone']) ?></td><td><ul class="order-items"><?php foreach($items as $item): ?><li><?= e($item['product_name']) ?> × <?= (int)$item['quantity'] ?></li><?php endforeach; ?></ul></td><td><?= aud($order['total_amount']) ?></td><td><?= e($order['shipping_address']) ?></td><td><form method="post"><input type="hidden" name="order_id" value="<?= (int)$order['order_id'] ?>"><select name="status"><?php foreach(['Pending','Confirmed','Packed','Shipped','Delivered','Cancelled'] as $status): ?><option value="<?= e($status) ?>" <?= $order['status']===$status?'selected':'' ?>><?= e($status) ?></option><?php endforeach; ?></select><button class="btn btn-ghost" type="submit" style="margin-top:.5rem;">Update</button></form></td></tr>
<?php endforeach; ?>
</tbody></table></div></div></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
