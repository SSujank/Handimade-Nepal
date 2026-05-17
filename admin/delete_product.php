<?php
require_once __DIR__ . '/../includes/admin_check.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
$id = (int)($_GET['id'] ?? 0);
if($id>0){
    try {
        $stmt=$pdo->prepare('DELETE FROM products WHERE product_id=?');
        $stmt->execute([$id]);
        set_flash('success','Product deleted.');
    } catch (Exception $e) {
        $stmt=$pdo->prepare('UPDATE products SET is_active=0 WHERE product_id=?');
        $stmt->execute([$id]);
        set_flash('info','Product is linked to orders, so it was deactivated instead of deleted.');
    }
}
redirect('admin/manage_products.php');
?>
