<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!validate_email($email)) $errors[] = 'Enter a valid email address.';
    if ($password === '') $errors[] = 'Password is required.';
    if (!$errors) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email=?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            set_flash('success', 'Welcome back, ' . $user['full_name'] . '.');
            redirect($user['role'] === 'admin' ? 'admin/dashboard.php' : 'products.php');
        } else {
            $errors[] = 'Invalid email or password.';
        }
    }
}
$pageTitle = 'Login — Handicraft Nepal Online Store';
$pageDescription = 'Login to your customer or admin account.';
require __DIR__ . '/includes/header.php';
?>
<section class="page-header"><div class="container"><h1>Login</h1><p>Access your account, view orders and manage your shopping details.</p></div></section>
<section class="section"><div class="container"><div class="auth-wrap"><div class="auth-card">
<?php foreach($errors as $error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endforeach; ?>
<form method="post">
<div class="form-field"><label for="email">Email *</label><input id="email" name="email" type="email" required value="<?= e($_POST['email'] ?? '') ?>"></div>
<div class="form-field"><label for="password">Password *</label><input id="password" name="password" type="password" required></div>
<div class="form-actions"><button class="btn btn-primary" type="submit">Login</button><a class="btn btn-ghost" href="<?= url('register.php') ?>">Create account</a></div>
</form>
</div></div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
