<?php
require_once __DIR__ . '/../includes/admin_check.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $name=trim($_POST['customer_name'] ?? ''); $location=trim($_POST['location'] ?? ''); $rating=(int)($_POST['rating'] ?? 5); $comment=trim($_POST['comment'] ?? '');
    if(strlen($name)>=2 && strlen($location)>=2 && strlen($comment)>=10){
        $stmt=$pdo->prepare('INSERT INTO testimonials (customer_name, location, rating, comment, is_approved) VALUES (?,?,?,?,1)');
        $stmt->execute([$name,$location,max(1,min(5,$rating)),$comment]);
        set_flash('success','Review added.');
    } else { set_flash('error','Please fill all review fields properly.'); }
    redirect('admin/manage_testimonials.php');
}
$reviews=$pdo->query('SELECT * FROM testimonials ORDER BY created_at DESC')->fetchAll();
$pageTitle='Manage Reviews — Admin';
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/_admin_nav.php';
?>
<section class="page-header"><div class="container"><h1>Manage reviews</h1><p>Add and view customer testimonials shown on the public review page.</p></div></section>
<section class="section"><div class="container"><div class="story-grid"><div class="auth-card"><h2>Add review</h2><form method="post"><div class="form-field"><label for="customer_name">Customer name</label><input id="customer_name" name="customer_name" required></div><div class="form-field"><label for="location">Location</label><input id="location" name="location" required></div><div class="form-field"><label for="rating">Rating</label><input id="rating" name="rating" type="number" min="1" max="5" value="5" required></div><div class="form-field"><label for="comment">Comment</label><textarea id="comment" name="comment" required></textarea></div><button class="btn btn-primary" type="submit">Add review</button></form></div><div class="table-card"><h2>Existing reviews</h2><div class="table-scroll"><table class="admin-table"><thead><tr><th>Name</th><th>Rating</th><th>Comment</th></tr></thead><tbody><?php foreach($reviews as $r): ?><tr><td><?= e($r['customer_name']) ?><br><span class="small-text"><?= e($r['location']) ?></span></td><td><?= (int)$r['rating'] ?>/5</td><td><?= e($r['comment']) ?></td></tr><?php endforeach; ?></tbody></table></div></div></div></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
