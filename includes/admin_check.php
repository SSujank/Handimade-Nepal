<?php
require_once __DIR__ . '/functions.php';
if (!is_logged_in()) {
    set_flash('error', 'Please login first.');
    redirect('login.php');
}
if (!is_admin()) {
    http_response_code(403);
    die('<h1>Access denied</h1><p>This area is only available for admin users.</p><p><a href="' . url('index.php') . '">Return to website</a></p>');
}
?>
