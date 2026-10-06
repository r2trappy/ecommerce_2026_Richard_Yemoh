<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url() . 'views/admin/brand.php');
}

$name = trim(strip_tags($_POST['brand_name'] ?? ''));

if ($name === '' || strlen($name) > 100) {
    $_SESSION['error'] = 'Please enter a brand name (100 characters max).';
    redirect(base_url() . 'views/admin/brand.php');
}

$controller = new ProductController();

if ($controller->addBrand($name)) {
    $_SESSION['success'] = 'Brand added.';
} else {
    $_SESSION['error'] = 'Could not add the brand.';
}

redirect(base_url() . 'views/admin/brand.php');
