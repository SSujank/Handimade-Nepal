<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    $consent = isset($_POST['consent']);
    if (strlen($name) < 2) $errors[] = 'Full name must be at least 2 characters.';
    if (!validate_email($email)) $errors[] = 'Enter a valid email address.';
    if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';
    if ($password !== $confirm) $errors[] = 'Passwords do not match.';
    if (!$consent) $errors[] = 'You must agree to the privacy notice.';
    if (!$errors) {
        $check = $pdo->prepare('SELECT user_id FROM users WHERE email=?');
        $check->execute([$email]);
        if ($check->fetch()) {
            $errors[] = 'This email is already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (full_name,email,password_hash,role,phone,address) VALUES (?,?,?,?,?,?)');
            $stmt->execute([$name,$email,$hash,'customer',$phone,$address]);
            set_flash('success', 'Account created. You can now login.');
            redirect('login.php');
        }
    }
}
$pageTitle = 'Register — Handicraft Nepal Online Store';
$pageDescription = 'Create a customer account for Handicraft Nepal Online Store.';
require __DIR__ . '/includes/header.php';
?>
<section class="page-header"><div class="container"><h1>Create account</h1><p>Register to place orders and view your order history.</p></div></section>
<section class="section"><div class="container"><div class="auth-wrap"><div class="auth-card">
<?php foreach($errors as $error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endforeach; ?>
<form method="post">
<div class="form-field"><label for="full_name">Full name *</label><input id="full_name" name="full_name" type="text" minlength="2" maxlength="100" required value="<?= e($_POST['full_name'] ?? '') ?>"></div>
<div class="form-field"><label for="email">Email *</label><input id="email" name="email" type="email" required value="<?= e($_POST['email'] ?? '') ?>"></div>
<div class="form-row"><div class="form-field"><label for="phone">Phone</label><input id="phone" name="phone" type="tel" value="<?= e($_POST['phone'] ?? '') ?>"></div><div class="form-field"><label for="address">Address</label><input id="address" name="address" type="text" maxlength="255" value="<?= e($_POST['address'] ?? '') ?>"></div></div>
<div class="form-row"><div class="form-field"><label for="password">Password *</label><input id="password" name="password" type="password" minlength="8" required></div><div class="form-field"><label for="confirm_password">Confirm password *</label><input id="confirm_password" name="confirm_password" type="password" minlength="8" required></div></div>
<div class="checkbox-field"><input id="consent" name="consent" type="checkbox" required><label for="consent" style="margin-bottom:0;font-weight:400;">I agree for my account details to be stored for order processing. *</label></div>
<div class="form-actions"><button class="btn btn-primary" type="submit">Register</button><a class="btn btn-ghost" href="<?= url('login.php') ?>">Already have account?</a></div>
</form>
</div></div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
