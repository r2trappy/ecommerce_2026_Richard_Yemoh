<?php require_once __DIR__ . '/../../core/core.php'; ?>
<?php require_admin(); ?>
<?php
require_once __DIR__ . '/../../controllers/ProductController.php';

$controller = new ProductController();
$categories = $controller->getAllCategories();
$brands = $controller->getAllBrands();
$products = $controller->getAllProducts();

$editProduct = false;
$editId = filter_var($_GET['edit_id'] ?? '', FILTER_VALIDATE_INT);
if ($editId && $editId > 0) {
    $editProduct = $controller->getProductById($editId);
}
?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="admin-page">
    <h2><?php echo $editProduct ? 'Edit Product' : 'Add Product'; ?></h2>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert"><?php echo htmlspecialchars($_SESSION['success']); ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (empty($categories) || empty($brands)): ?>
        <p>Please add at least one category and one brand before adding products.</p>
    <?php else: ?>
    <form id="product-form" action="<?php echo base_url(); ?>actions/<?php echo $editProduct ? 'update_product_action.php' : 'add_product_action.php'; ?>" method="POST" enctype="multipart/form-data">
        <?php if ($editProduct): ?>
            <input type="hidden" name="product_id" value="<?php echo (int)$editProduct['product_id']; ?>">
            <input type="hidden" name="current_image" value="<?php echo htmlspecialchars((string)$editProduct['product_image']); ?>">
        <?php endif; ?>

        <label for="product_title">Product Title</label>
        <input type="text" name="product_title" id="product_title" maxlength="150" required value="<?php echo $editProduct ? htmlspecialchars($editProduct['product_title']) : ''; ?>">
        <span class="field-error" id="title-error"></span>

        <label for="product_cat">Category</label>
        <select name="product_cat" id="product_cat" required>
            <option value="">Select a category</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo (int)$cat['cat_id']; ?>" <?php echo ($editProduct && (int)$editProduct['product_cat'] === (int)$cat['cat_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($cat['cat_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="product_brand">Brand</label>
        <select name="product_brand" id="product_brand" required>
            <option value="">Select a brand</option>
            <?php foreach ($brands as $brand): ?>
                <option value="<?php echo (int)$brand['brand_id']; ?>" <?php echo ($editProduct && (int)$editProduct['product_brand'] === (int)$brand['brand_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($brand['brand_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="product_price">Price (GH₵)</label>
        <input type="number" name="product_price" id="product_price" step="0.01" min="0.01" required value="<?php echo $editProduct ? htmlspecialchars($editProduct['product_price']) : ''; ?>">
        <span class="field-error" id="price-error"></span>

        <label for="product_desc">Description</label>
        <textarea name="product_desc" id="product_desc" rows="4" required><?php echo $editProduct ? htmlspecialchars($editProduct['product_desc']) : ''; ?></textarea>

        <label for="product_keywords">Keywords</label>
        <input type="text" name="product_keywords" id="product_keywords" maxlength="255" value="<?php echo $editProduct ? htmlspecialchars((string)$editProduct['product_keywords']) : ''; ?>">

        <label for="product_image">Image (JPG, PNG, GIF or WEBP, max 2MB)</label>
        <?php if ($editProduct && !empty($editProduct['product_image'])): ?>
            <div class="current-image">
                <img src="<?php echo base_url(); ?>images/products/<?php echo htmlspecialchars(rawurlencode($editProduct['product_image'])); ?>" alt="Current image" width="120">
                <p>Current image. Choose a new file only if you want to replace it.</p>
            </div>
        <?php endif; ?>
        <input type="file" name="product_image" id="product_image" accept="image/jpeg,image/png,image/gif,image/webp">
        <span class="field-error" id="image-error"></span>

        <button type="submit"><?php echo $editProduct ? 'Update Product' : 'Add Product'; ?></button>
        <?php if ($editProduct): ?>
            <a href="<?php echo base_url(); ?>views/admin/product.php">Cancel</a>
        <?php endif; ?>
    </form>
    <?php endif; ?>

    <h3>All Products</h3>
    <table class="data-table">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Brand</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php foreach ($products as $p): ?>
            <tr>
                <td><?php echo (int)$p['product_id']; ?></td>
                <td><?php echo htmlspecialchars($p['product_title']); ?></td>
                <td><?php echo htmlspecialchars($p['cat_name']); ?></td>
                <td><?php echo htmlspecialchars($p['brand_name']); ?></td>
                <td>GH₵ <?php echo number_format((float)$p['product_price'], 2); ?></td>
                <td><a class="btn-link" href="<?php echo base_url(); ?>views/admin/product.php?edit_id=<?php echo (int)$p['product_id']; ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
