<?php require_once __DIR__ . '/../../core/core.php'; ?>
<?php require_admin(); ?>
<?php
require_once __DIR__ . '/../../controllers/ProductController.php';

$controller = new ProductController();
$categories = $controller->getAllCategories();

$editCategory = false;
$editId = filter_var($_GET['edit_id'] ?? '', FILTER_VALIDATE_INT);
if ($editId && $editId > 0) {
    $editCategory = $controller->getCategoryById($editId);
}
?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="admin-page">
    <h2><?php echo $editCategory ? 'Edit Category' : 'Add Category'; ?></h2>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert"><?php echo htmlspecialchars($_SESSION['success']); ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="<?php echo base_url(); ?>actions/<?php echo $editCategory ? 'update_category_action.php' : 'add_category_action.php'; ?>" method="POST">
        <?php if ($editCategory): ?>
            <input type="hidden" name="cat_id" value="<?php echo (int)$editCategory['cat_id']; ?>">
        <?php endif; ?>
        <label for="cat_name">Category name</label>
        <input type="text" name="cat_name" id="cat_name" maxlength="100" required value="<?php echo $editCategory ? htmlspecialchars($editCategory['cat_name']) : ''; ?>">
        <button type="submit"><?php echo $editCategory ? 'Update Category' : 'Add Category'; ?></button>
        <?php if ($editCategory): ?>
            <a href="<?php echo base_url(); ?>views/admin/category.php">Cancel</a>
        <?php endif; ?>
    </form>

    <h3>All Categories</h3>
    <table class="data-table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
        <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?php echo (int)$cat['cat_id']; ?></td>
                <td><?php echo htmlspecialchars($cat['cat_name']); ?></td>
                <td><a class="btn-link" href="<?php echo base_url(); ?>views/admin/category.php?edit_id=<?php echo (int)$cat['cat_id']; ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
