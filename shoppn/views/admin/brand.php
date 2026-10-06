<?php require_once __DIR__ . '/../../core/core.php'; ?>
<?php require_admin(); ?>
<?php
require_once __DIR__ . '/../../controllers/ProductController.php';

$controller = new ProductController();
$brands = $controller->getAllBrands();

$editBrand = false;
$editId = filter_var($_GET['edit_id'] ?? '', FILTER_VALIDATE_INT);
if ($editId && $editId > 0) {
    $editBrand = $controller->getBrandById($editId);
}
?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="admin-page">
    <h2><?php echo $editBrand ? 'Edit Brand' : 'Add Brand'; ?></h2>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert"><?php echo htmlspecialchars($_SESSION['success']); ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="<?php echo base_url(); ?>actions/<?php echo $editBrand ? 'update_brand_action.php' : 'add_brand_action.php'; ?>" method="POST">
        <?php if ($editBrand): ?>
            <input type="hidden" name="brand_id" value="<?php echo (int)$editBrand['brand_id']; ?>">
        <?php endif; ?>
        <label for="brand_name">Brand name</label>
        <input type="text" name="brand_name" id="brand_name" maxlength="100" required value="<?php echo $editBrand ? htmlspecialchars($editBrand['brand_name']) : ''; ?>">
        <button type="submit"><?php echo $editBrand ? 'Update Brand' : 'Add Brand'; ?></button>
        <?php if ($editBrand): ?>
            <a href="<?php echo base_url(); ?>views/admin/brand.php">Cancel</a>
        <?php endif; ?>
    </form>

    <h3>All Brands</h3>
    <table class="data-table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
        <?php foreach ($brands as $brand): ?>
            <tr>
                <td><?php echo (int)$brand['brand_id']; ?></td>
                <td><?php echo htmlspecialchars($brand['brand_name']); ?></td>
                <td><a class="btn-link" href="<?php echo base_url(); ?>views/admin/brand.php?edit_id=<?php echo (int)$brand['brand_id']; ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
