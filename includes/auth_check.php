<?php
require_once __DIR__ . '/functions.php';
if (!is_logged_in()) {
    set_flash('error', 'Please login first to continue.');
    redirect('login.php');
}
?>
