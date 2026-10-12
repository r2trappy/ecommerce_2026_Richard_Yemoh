<?php
require_once __DIR__ . '/../controllers/ProductController.php';

$controller = new ProductController();

$catId = filter_var($_GET['cat'] ?? '', FILTER_VALIDATE_INT);
$brandId = filter_var($_GET['brand'] ?? '', FILTER_VALIDATE_INT);

if ($catId && $catId > 0) {
    $heading = 'Products by Category';
    $products = $controller->getProductsByCategory($catId);
} elseif ($brandId && $brandId > 0) {
    $heading = 'Products by Brand';
    $products = $controller->getProductsByBrand($brandId);
} else {
    $heading = 'Featured Products';
    $products = $controller->getFeaturedProducts(6);
}

$cartNotice = isset($_GET['add_cart']);
?>
<?php require_once __DIR__ . '/layout/header.php'; ?>
<?php require_once __DIR__ . '/layout/sidebar.php'; ?>

<section class="home-content">
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if ($cartNotice): ?>
        <div class="alert">The cart is not available yet.</div>
    <?php endif; ?>

    <h1><?php echo $heading; ?></h1>

    <?php if (empty($products)): ?>
        <p>No products found.</p>
    <?php else: ?>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <?php require __DIR__ . '/layout/product_card.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
