<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $topic = trim($_POST['topic'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;
    $consent = isset($_POST['consent']) ? 1 : 0;
    if (strlen($name) < 2) $errors[] = 'Name must be at least 2 characters.';
    if (!validate_email($email)) $errors[] = 'Valid email is required.';
    if ($topic === '') $errors[] = 'Please choose a topic.';
    if (strlen($subject) < 3) $errors[] = 'Subject must be at least 3 characters.';
    if (strlen($message) < 10) $errors[] = 'Message must be at least 10 characters.';
    if (!$consent) $errors[] = 'You must agree for your message to be stored so we can reply.';
    if (!$errors) {
        $stmt = $pdo->prepare('INSERT INTO contact_messages (name,email,phone,topic,subject,message,newsletter,consent) VALUES (?,?,?,?,?,?,?,?)');
        $stmt->execute([$name,$email,$phone,$topic,$subject,$message,$newsletter,$consent]);
        set_flash('success', 'Your message has been saved. We will reply within 2 business days.');
        redirect('contact.php');
    }
}
$pageTitle = 'Contact — Handicraft Nepal Online Store';
$pageDescription = 'Contact Handicraft Nepal Online Store for order, product, shipping or wholesale enquiries.';
$active = 'contact';
require __DIR__ . '/includes/header.php';
?>
<section class="page-header"><div class="container"><h1>Contact us</h1><p>Questions about an order, product, shipping or wholesale enquiry? Send us a message and our team will reply soon.</p></div></section>
<section class="section"><div class="container"><div class="contact-grid">
<aside class="contact-info"><h2>Reach us</h2><p style="color:var(--clr-brown);margin-bottom:var(--space-md);">We aim to reply within 2 business days. Prices are shown in AUD for online customers.</p>
<div class="contact-detail"><div class="contact-detail-icon" aria-hidden="true">✉</div><div class="contact-detail-text"><strong>Email</strong><a href="mailto:hello@handicraftnepal.com">hello@handicraftnepal.com</a></div></div>
<div class="contact-detail"><div class="contact-detail-icon" aria-hidden="true">☏</div><div class="contact-detail-text"><strong>Phone / WhatsApp</strong><a href="tel:+97714424567">+977 1 4424 567</a></div></div>
<div class="contact-detail"><div class="contact-detail-icon" aria-hidden="true">◎</div><div class="contact-detail-text"><strong>Showroom</strong><span>Thamel Marg, Kathmandu 44600, Nepal</span></div></div>
<div class="privacy-box"><strong>Privacy note:</strong> Contact messages are used only so the business can reply to your enquiry.</div>
</aside>
<section class="contact-form" aria-labelledby="form-heading"><h2 id="form-heading">Send a message</h2><p class="form-intro">Fields marked with * are required. Please enter your details carefully before submission.</p>
<?php foreach($errors as $error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endforeach; ?>
<div id="form-feedback" class="form-feedback" role="status" aria-live="polite"></div>
<form id="contact-form" method="post" novalidate>
<div class="form-row"><div class="form-field"><label for="name">Your name *</label><input id="name" name="name" type="text" required minlength="2" maxlength="60" value="<?= e($_POST['name'] ?? '') ?>"></div><div class="form-field"><label for="email">Email *</label><input id="email" name="email" type="email" required value="<?= e($_POST['email'] ?? '') ?>"></div></div>
<div class="form-row"><div class="form-field"><label for="phone">Phone</label><input id="phone" name="phone" type="tel" value="<?= e($_POST['phone'] ?? '') ?>"></div><div class="form-field"><label for="topic">Topic *</label><select id="topic" name="topic" required><option value="">Choose a topic…</option><?php foreach(['order'=>'Order enquiry','wholesale'=>'Wholesale / stockist','shipping'=>'Shipping question','custom'=>'Custom order','other'=>'Something else'] as $value=>$label): ?><option value="<?= e($value) ?>" <?= ($_POST['topic'] ?? '')===$value?'selected':'' ?>><?= e($label) ?></option><?php endforeach; ?></select></div></div>
<div class="form-field"><label for="subject">Subject *</label><input id="subject" name="subject" type="text" required minlength="3" maxlength="150" value="<?= e($_POST['subject'] ?? '') ?>"></div>
<div class="form-field"><label for="message">Message *</label><textarea id="message" name="message" required minlength="10" maxlength="1000"><?= e($_POST['message'] ?? '') ?></textarea></div>
<div class="checkbox-field"><input id="newsletter" name="newsletter" type="checkbox" value="yes" <?= isset($_POST['newsletter'])?'checked':'' ?>><label for="newsletter" style="margin-bottom:0;font-weight:400;">Send me occasional updates about new arrivals.</label></div>
<div class="checkbox-field"><input id="consent" name="consent" type="checkbox" value="yes" required><label for="consent" style="margin-bottom:0;font-weight:400;">I agree for my message to be stored so Handicraft Nepal can reply. *</label></div>
<button class="btn btn-primary submit-btn" type="submit">Send message</button>
</form></section>
</div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
