<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';
require_once __DIR__ . '/../controllers/ProductController.php';

function back_url() {
    $ref = $_SERVER['HTTP_REFERER'] ?? '';
    $refHost = parse_url($ref, PHP_URL_HOST);
    $myHost = parse_url('http://' . ($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_HOST);
    if ($refHost && $myHost && strcasecmp($refHost, $myHost) === 0 && strpos($ref, 'add_to_cart_action.php') === false) {
        return $ref;
    }
    return base_url() . 'index.php';
}

$productId = filter_var($_GET['add_cart'] ?? '', FILTER_VALIDATE_INT);

if (!$productId || $productId < 1) {
    $_SESSION['cart_msg'] = 'That product could not be added to your cart.';
    redirect(back_url());
}

$productController = new ProductController();

if (!$productController->getProductById($productId)) {
    $_SESSION['cart_msg'] = 'That product does not exist.';
    redirect(back_url());
}

$cartController = new CartController();
$ip = get_ip();

if ($cartController->isInCart($productId, $ip)) {
    $_SESSION['cart_msg'] = 'This item is already in your cart. Go to cart to update quantity.';
    redirect(back_url());
}

$customerId = is_logged_in() ? (int)$_SESSION['customer_id'] : null;

if ($cartController->addToCart($productId, 1, $ip, $customerId)) {
    $_SESSION['cart_msg'] = 'Item added to your cart.';
} else {
    $_SESSION['cart_msg'] = 'Could not add the item to your cart.';
}

redirect(back_url());
