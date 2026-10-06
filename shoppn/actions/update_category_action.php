<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url() . 'views/admin/category.php');
}

$id = filter_var($_POST['cat_id'] ?? '', FILTER_VALIDATE_INT);
$name = trim(strip_tags($_POST['cat_name'] ?? ''));

if (!$id || $id < 1 || $name === '' || strlen($name) > 100) {
    $_SESSION['error'] = 'Please enter a valid category name (100 characters max).';
    redirect(base_url() . 'views/admin/category.php');
}

$controller = new ProductController();

if ($controller->updateCategory($id, $name)) {
    $_SESSION['success'] = 'Category updated.';
} else {
    $_SESSION['error'] = 'Could not update the category.';
}

redirect(base_url() . 'views/admin/category.php');
