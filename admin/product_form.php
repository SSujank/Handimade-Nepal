<?php
require_once __DIR__ . '/../includes/admin_check.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
$id = (int)($_GET['id'] ?? 0);
$categories = $pdo->query('SELECT * FROM categories ORDER BY category_name')->fetchAll();
$product = ['category_id'=>'','product_name'=>'','description'=>'','price'=>'','stock'=>'','image_url'=>'','is_featured'=>0,'is_active'=>1];
if ($id > 0) { $stmt=$pdo->prepare('SELECT * FROM products WHERE product_id=?'); $stmt->execute([$id]); $product=$stmt->fetch(); if(!$product){die('Product not found.');} }
$errors=[];
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $category_id=(int)($_POST['category_id'] ?? 0);
    $name=trim($_POST['product_name'] ?? '');
    $description=trim($_POST['description'] ?? '');
    $price=(float)($_POST['price'] ?? 0);
    $stock=(int)($_POST['stock'] ?? 0);
    $image=trim($_POST['image_url'] ?? '');
    $featured=isset($_POST['is_featured'])?1:0;
    $active=isset($_POST['is_active'])?1:0;
    if($category_id<=0) $errors[]='Choose a category.';
    if(strlen($name)<3) $errors[]='Product name must be at least 3 characters.';
    if(strlen($description)<10) $errors[]='Description must be at least 10 characters.';
    if($price<=0) $errors[]='Price must be greater than zero.';
    if($stock<0) $errors[]='Stock cannot be negative.';
    if(!filter_var($image, FILTER_VALIDATE_URL)) $errors[]='Image URL must be a valid URL.';
    if(!$errors){
        if($id>0){
            $stmt=$pdo->prepare('UPDATE products SET category_id=?, product_name=?, description=?, price=?, stock=?, image_url=?, is_featured=?, is_active=? WHERE product_id=?');
            $stmt->execute([$category_id,$name,$description,$price,$stock,$image,$featured,$active,$id]);
            set_flash('success','Product updated successfully.');
        } else {
            $stmt=$pdo->prepare('INSERT INTO products (category_id, product_name, description, price, stock, image_url, is_featured, is_active) VALUES (?,?,?,?,?,?,?,?)');
            $stmt->execute([$category_id,$name,$description,$price,$stock,$image,$featured,$active]);
            set_flash('success','Product added successfully.');
        }
        redirect('admin/manage_products.php');
    }
    $product = compact('category_id','name','description','price','stock','image','featured','active');
    $product['product_name']=$name; $product['image_url']=$image; $product['is_featured']=$featured; $product['is_active']=$active;
}
$pageTitle = ($id ? 'Edit Product' : 'Add Product') . ' — Admin';
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/_admin_nav.php';
?>
<section class="page-header"><div class="container"><h1><?= $id ? 'Edit product' : 'Add product' ?></h1><p>Use clear product names, ethical descriptions and accessible image URLs.</p></div></section>
<section class="section"><div class="container"><div class="auth-card">
<?php foreach($errors as $error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endforeach; ?>
<form method="post">
<div class="form-row"><div class="form-field"><label for="category_id">Category *</label><select id="category_id" name="category_id" required><option value="">Choose category</option><?php foreach($categories as $cat): ?><option value="<?= (int)$cat['category_id'] ?>" <?= (int)$product['category_id']===(int)$cat['category_id']?'selected':'' ?>><?= e($cat['category_name']) ?></option><?php endforeach; ?></select></div><div class="form-field"><label for="product_name">Product name *</label><input id="product_name" name="product_name" type="text" required value="<?= e($product['product_name']) ?>"></div></div>
<div class="form-field"><label for="description">Description *</label><textarea id="description" name="description" required><?= e($product['description']) ?></textarea></div>
<div class="form-row"><div class="form-field"><label for="price">Price AUD *</label><input id="price" name="price" type="number" step="0.01" min="0" required value="<?= e($product['price']) ?>"></div><div class="form-field"><label for="stock">Stock *</label><input id="stock" name="stock" type="number" min="0" required value="<?= e($product['stock']) ?>"></div></div>
<div class="form-field"><label for="image_url">Image URL *</label><input id="image_url" name="image_url" type="url" required value="<?= e($product['image_url']) ?>"></div>
<div class="checkbox-field"><input id="is_featured" name="is_featured" type="checkbox" <?= $product['is_featured']?'checked':'' ?>><label for="is_featured" style="margin-bottom:0;font-weight:400;">Show as featured product</label></div>
<div class="checkbox-field"><input id="is_active" name="is_active" type="checkbox" <?= $product['is_active']?'checked':'' ?>><label for="is_active" style="margin-bottom:0;font-weight:400;">Product is active</label></div>
<div class="form-actions"><button class="btn btn-primary" type="submit">Save product</button><a class="btn btn-ghost" href="<?= url('admin/manage_products.php') ?>">Cancel</a></div>
</form>
</div></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
