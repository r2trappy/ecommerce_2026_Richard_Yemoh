<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../core/upload.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url() . 'views/admin/product.php');
}

$id = filter_var($_POST['product_id'] ?? '', FILTER_VALIDATE_INT);
$cat = filter_var($_POST['product_cat'] ?? '', FILTER_VALIDATE_INT);
$brand = filter_var($_POST['product_brand'] ?? '', FILTER_VALIDATE_INT);
$title = trim(strip_tags($_POST['product_title'] ?? ''));
$priceRaw = trim($_POST['product_price'] ?? '');
$desc = trim(strip_tags($_POST['product_desc'] ?? ''));
$keywords = trim(strip_tags($_POST['product_keywords'] ?? ''));

$price = filter_var($priceRaw, FILTER_VALIDATE_FLOAT);

if (!$id || $id < 1) {
    $_SESSION['error'] = 'Invalid product.';
    redirect(base_url() . 'views/admin/product.php');
}

$editUrl = base_url() . 'views/admin/product.php?edit_id=' . $id;

if (!$cat || $cat < 1 || !$brand || $brand < 1) {
    $_SESSION['error'] = 'Please choose a category and a brand.';
    redirect($editUrl);
}

if ($title === '' || strlen($title) > 150) {
    $_SESSION['error'] = 'Please enter a product title (150 characters max).';
    redirect($editUrl);
}

if ($price === false || $price <= 0 || $price > 99999999) {
    $_SESSION['error'] = 'Please enter a valid price greater than 0.';
    redirect($editUrl);
}

if ($desc === '') {
    $_SESSION['error'] = 'Please enter a description.';
    redirect($editUrl);
}

if (strlen($keywords) > 255) {
    $_SESSION['error'] = 'Keywords must be 255 characters or fewer.';
    redirect($editUrl);
}

$controller = new ProductController();
$existing = $controller->getProductById($id);

if (!$existing) {
    $_SESSION['error'] = 'That product does not exist.';
    redirect(base_url() . 'views/admin/product.php');
}

if (!$controller->getCategoryById($cat) || !$controller->getBrandById($brand)) {
    $_SESSION['error'] = 'The chosen category or brand does not exist.';
    redirect($editUrl);
}

$image = $existing['product_image'];
$hidden = basename(trim($_POST['current_image'] ?? ''));
if ($hidden !== '' && $hidden === $image) {
    $image = $hidden;
}

$upload = save_product_image($_FILES['product_image'] ?? null);

if ($upload['error'] !== null) {
    $_SESSION['error'] = $upload['error'];
    redirect($editUrl);
}

if ($upload['filename'] !== null) {
    $image = $upload['filename'];
}

$keywordsValue = $keywords === '' ? null : $keywords;

if ($controller->updateProduct($id, $cat, $brand, $title, $price, $desc, $image, $keywordsValue)) {
    $_SESSION['success'] = 'Product updated.';
} else {
    $_SESSION['error'] = 'Could not update the product.';
}

redirect(base_url() . 'views/admin/product.php');
