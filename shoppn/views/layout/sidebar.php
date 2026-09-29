<?php
require_once __DIR__ . '/../../controllers/ProductController.php';
$productController = new ProductController();
$categories = $productController->getAllCategories();
$brands = $productController->getAllBrands();
?>
<aside class="sidebar">
    <h3>Categories</h3>
    <ul>
        <?php if (empty($categories)): ?>
            <li>No categories yet</li>
        <?php endif; ?>
        <?php foreach ($categories as $cat): ?>
            <li><a href="<?php echo base_url(); ?>index.php?cat=<?php echo (int)$cat['cat_id']; ?>">
                <?php echo htmlspecialchars($cat['cat_name']); ?>
            </a></li>
        <?php endforeach; ?>
    </ul>

    <h3>Brands</h3>
    <ul>
        <?php if (empty($brands)): ?>
            <li>No brands yet</li>
        <?php endif; ?>
        <?php foreach ($brands as $brand): ?>
            <li><a href="<?php echo base_url(); ?>index.php?brand=<?php echo (int)$brand['brand_id']; ?>">
                <?php echo htmlspecialchars($brand['brand_name']); ?>
            </a></li>
        <?php endforeach; ?>
    </ul>
</aside>
