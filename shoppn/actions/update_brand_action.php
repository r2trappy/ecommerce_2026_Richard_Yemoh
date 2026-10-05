<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url() . 'views/admin/brand.php');
}

$id = filter_var($_POST['brand_id'] ?? '', FILTER_VALIDATE_INT);
$name = trim(strip_tags($_POST['brand_name'] ?? ''));

if (!$id || $id < 1 || $name === '' || strlen($name) > 100) {
    $_SESSION['error'] = 'Please enter a valid brand name (100 characters max).';
    redirect(base_url() . 'views/admin/brand.php');
}

$controller = new ProductController();

if ($controller->updateBrand($id, $name)) {
    $_SESSION['success'] = 'Brand updated.';
} else {
    $_SESSION['error'] = 'Could not update the brand.';
}

redirect(base_url() . 'views/admin/brand.php');
