<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$controller = new ProductController();

$query = trim(strip_tags($_GET['user_query'] ?? ''));
$products = [];

if ($query !== '') {
    $products = $controller->searchProducts($query);
}
?>
<?php require_once __DIR__ . '/layout/header.php'; ?>
<?php require_once __DIR__ . '/layout/sidebar.php'; ?>

<section class="home-content">
    <h1>Search Results</h1>

    <?php if ($query === ''): ?>
        <p>Please type something to search for.</p>
    <?php elseif (empty($products)): ?>
        <p>No products found for "<?php echo htmlspecialchars($query); ?>".</p>
    <?php else: ?>
        <p>Results for "<?php echo htmlspecialchars($query); ?>"</p>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <?php require __DIR__ . '/layout/product_card.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
