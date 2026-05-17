<?php
require_once __DIR__ . '/../includes/admin_check.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $id=(int)($_POST['message_id'] ?? 0);
    $status=$_POST['status'] ?? 'New';
    if($id>0 && in_array($status,['New','Read','Replied'],true)){
        $stmt=$pdo->prepare('UPDATE contact_messages SET status=? WHERE message_id=?');
        $stmt->execute([$status,$id]);
        set_flash('success','Message status updated.');
    }
    redirect('admin/manage_messages.php');
}
$messages=$pdo->query('SELECT * FROM contact_messages ORDER BY created_at DESC')->fetchAll();
$pageTitle='Manage Messages — Admin';
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/_admin_nav.php';
?>
<section class="page-header"><div class="container"><h1>Contact messages</h1><p>Review customer enquiries submitted through the contact form.</p></div></section>
<section class="section"><div class="container"><div class="table-card"><div class="table-scroll"><table class="admin-table"><thead><tr><th>Sender</th><th>Topic</th><th>Subject & Message</th><th>Newsletter</th><th>Status</th></tr></thead><tbody>
<?php foreach($messages as $m): ?><tr><td><?= e($m['name']) ?><br><a href="mailto:<?= e($m['email']) ?>"><?= e($m['email']) ?></a><br><?= e($m['phone']) ?><br><span class="small-text"><?= e($m['created_at']) ?></span></td><td><?= e($m['topic']) ?></td><td><strong><?= e($m['subject']) ?></strong><br><?= nl2br(e($m['message'])) ?></td><td><?= $m['newsletter'] ? 'Yes' : 'No' ?></td><td><form method="post"><input type="hidden" name="message_id" value="<?= (int)$m['message_id'] ?>"><select name="status"><?php foreach(['New','Read','Replied'] as $status): ?><option value="<?= e($status) ?>" <?= $m['status']===$status?'selected':'' ?>><?= e($status) ?></option><?php endforeach; ?></select><button class="btn btn-ghost" type="submit" style="margin-top:.5rem;">Update</button></form></td></tr><?php endforeach; ?>
</tbody></table></div></div></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
