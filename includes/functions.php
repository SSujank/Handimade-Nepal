<?php
require_once __DIR__ . '/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function app_base_path() {
    static $base = null;
    if ($base !== null) {
        return $base;
    }
    $dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $dir = rtrim($dir, '/');
    if (basename($dir) === 'admin') {
        $dir = rtrim(dirname($dir), '/');
    }
    $base = ($dir === '/' || $dir === '\\') ? '' : $dir;
    return $base;
}

function url($path = '') {
    return app_base_path() . '/' . ltrim($path, '/');
}

function redirect($path) {
    header('Location: ' . url($path));
    exit;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function current_user_name() {
    return $_SESSION['full_name'] ?? 'Guest';
}

function set_flash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function flash_message() {
    if (!isset($_SESSION['flash'])) {
        return '';
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    $class = $flash['type'] === 'success' ? 'alert-success' : ($flash['type'] === 'info' ? 'alert-info' : 'alert-error');
    return '<div class="alert ' . $class . '">' . e($flash['message']) . '</div>';
}

function cart_count() {
    $total = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $qty) {
            $total += (int)$qty;
        }
    }
    return $total;
}

function aud($amount) {
    return 'AUD ' . number_format((float)$amount, 2);
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function require_post() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect('index.php');
    }
}
?>
