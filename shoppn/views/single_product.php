<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$controller = new ProductController();

$proId = filter_var($_GET['pro_id'] ?? '', FILTER_VALIDATE_INT);
$product = false;

if ($proId && $proId > 0) {
    $product = $controller->getProductById($proId);
}

if (!$product) {
    redirect(base_url() . 'index.php');
}
?>
<?php require_once __DIR__ . '/layout/header.php'; ?>
<?php require_once __DIR__ . '/layout/sidebar.php'; ?>

<section class="home-content single-product">
    <div class="single-image">
        <?php if (!empty($product['product_image'])): ?>
            <img src="<?php echo base_url(); ?>images/products/<?php echo htmlspecialchars(rawurlencode($product['product_image'])); ?>" alt="<?php echo htmlspecialchars($product['product_title']); ?>">
        <?php else: ?>
            <div class="no-image">No image</div>
        <?php endif; ?>
    </div>
    <div class="single-info">
        <h1><?php echo htmlspecialchars($product['product_title']); ?></h1>
        <p class="price">GH₵ <?php echo number_format((float)$product['product_price'], 2); ?></p>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($product['cat_name']); ?></p>
        <p><strong>Brand:</strong> <?php echo htmlspecialchars($product['brand_name']); ?></p>
        <p><strong>Description:</strong><br><?php echo nl2br(htmlspecialchars($product['product_desc'])); ?></p>
        <p><strong>Keywords:</strong> <?php echo htmlspecialchars((string)$product['product_keywords']); ?></p>
        <p><a class="btn-link" href="<?php echo base_url(); ?>actions/add_to_cart_action.php?add_cart=<?php echo (int)$product['product_id']; ?>">Add to Cart</a></p>
    </div>
</section>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
