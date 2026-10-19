<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url() . 'views/cart.php');
}

$remove = $_POST['remove'] ?? [];
if (!is_array($remove) || count($remove) === 0) {
    $_SESSION['cart_msg'] = 'Please tick the items you want to remove.';
    redirect(base_url() . 'views/cart.php');
}

$controller = new CartController();
$ip = get_ip();
$removed = 0;

foreach ($remove as $value) {
    $productId = filter_var($value, FILTER_VALIDATE_INT);
    if ($productId && $productId > 0 && $controller->removeFromCart($productId, $ip)) {
        $removed++;
    }
}

$_SESSION['cart_msg'] = $removed > 0 ? 'Selected items removed from your cart.' : 'No items were removed.';
redirect(base_url() . 'views/cart.php');
