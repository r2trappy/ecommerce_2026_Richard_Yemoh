<?php
require 'db.php';
$allowed = ['active', 'draft', 'sold_out'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('ssdis', $name, $description, $price, $stock, $status);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Add Product</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <form method="POST" action="create.php">
        <label>Name</label>
        <input type="text" name="name" required>
        <label>Description</label>
        <textarea name="description"></textarea>
        <label>Price (GH₵)</label>
        <input type="number" name="price" step="0.01" min="0" required>
        <label>Stock</label>
        <input type="number" name="stock" min="0" required>
        <label>Status</label>
        <select name="status">
            <option value="active">Active</option>
            <option value="draft">Draft</option>
            <option value="sold_out">Sold out</option>
        </select>
        <br><br>
        <button type="submit" class="btn">Save Product</button>
        <a href="index.php">Back</a>
    </form>
</body>
</html>
