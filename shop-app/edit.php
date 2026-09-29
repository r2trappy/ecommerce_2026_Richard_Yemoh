<?php
require 'db.php';
$allowed = ['active', 'draft', 'sold_out'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id     = (int)($_POST['id'] ?? 0);
    $name        = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = $_POST['price'] ?? '';
    $stock       = $_POST['stock'] ?? '';
    $status      = $_POST['status'] ?? 'active';

    if ($name === '') {
        $error = 'Product name is required.';
    } elseif (!is_numeric($price) || $price < 0) {
        $error = 'Price must be a number that is 0 or more.';
    } elseif (filter_var($stock, FILTER_VALIDATE_INT) === false || $stock < 0) {
        $error = 'Stock must be a whole number that is 0 or more.';
    } elseif (!in_array($status, $allowed, true)) {
        $error = 'Invalid status.';
    } else {
        $price = (float)$price;
        $stock = (int)$stock;
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, stock=?, status=? WHERE id=?");
        $stmt->bind_param('ssdisi', $name, $description, $price, $stock, $status, $post_id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        header('Location: index.php');
        exit;
    }
    $id = $post_id;
} else {
    $id = (int)($_GET['id'] ?? 0);
}

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$product) { die('Product not found.'); }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edit Product</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <form method="POST" action="edit.php">
        <input type="hidden" name="id" value="<?php echo (int)$product['id']; ?>">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        <label>Description</label>
        <textarea name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
        <label>Price (GH₵)</label>
        <input type="number" name="price" step="0.01" min="0" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        <label>Stock</label>
        <input type="number" name="stock" min="0" value="<?php echo (int)$product['stock']; ?>" required>
        <label>Status</label>
        <select name="status">
            <?php foreach ($allowed as $s): ?>
                <option value="<?php echo $s; ?>" <?php echo $product['status'] === $s ? 'selected' : ''; ?>>
                    <?php echo ucfirst(str_replace('_', ' ', $s)); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <button type="submit" class="btn">Update Product</button>
        <a href="index.php">Back</a>
    </form>
</body>
</html>