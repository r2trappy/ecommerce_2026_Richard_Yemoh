<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url() . 'views/cart.php');
}

$qtys = $_POST['qty'] ?? [];
$ids = $_POST['update'] ?? [];

if (!is_array($qtys) || !is_array($ids) || count($ids) === 0 || count($qtys) !== count($ids)) {
    $_SESSION['cart_msg'] = 'Nothing to update.';
    redirect(base_url() . 'views/cart.php');
}

$ids = array_values($ids);
$qtys = array_values($qtys);

$clean = [];
for ($i = 0; $i < count($ids); $i++) {
    $productId = filter_var($ids[$i], FILTER_VALIDATE_INT);
    $qty = filter_var(trim((string)$qtys[$i]), FILTER_VALIDATE_INT);
    if (!$productId || $productId < 1 || !$qty || $qty < 1 || $qty > 99) {
        $_SESSION['cart_msg'] = 'Each quantity must be a whole number from 1 to 99. Nothing was changed.';
        redirect(base_url() . 'views/cart.php');
    }
    $clean[$productId] = $qty;
}

$controller = new CartController();
$ip = get_ip();

foreach ($clean as $productId => $qty) {
    $controller->updateQty($productId, $qty, $ip);
}

$_SESSION['cart_msg'] = 'Cart updated.';
redirect(base_url() . 'views/cart.php');
