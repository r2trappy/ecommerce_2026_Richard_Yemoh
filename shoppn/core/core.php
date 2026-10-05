<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Africa/Accra');

require_once __DIR__ . '/db_class.php';

function get_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function is_logged_in() {
    return isset($_SESSION['customer_id']);
}

function is_admin() {
    return is_logged_in() && (int)($_SESSION['user_role'] ?? 0) === 1;
}

function require_login() {
    if (!is_logged_in()) {
        redirect(base_url() . 'views/login.php');
    }
}

function require_admin() {
    if (!is_admin()) {
        $_SESSION['error'] = 'You do not have permission to view that page.';
        redirect(base_url() . 'index.php');
    }
}

function base_url() {
    $script = $_SERVER['SCRIPT_NAME'];
    $root = preg_replace('#(views|actions)/.*$#', '', $script);
    $root = preg_replace('#/[^/]*\.php$#', '/', $root);
    return $root;
}
