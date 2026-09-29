<?php
require 'db.php';
$result = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Shop Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Shop Products</h1>
    <a class="btn" href="create.php">+ Add Product</a>

    <table>
        <tr>
            <th>Name</th><th>Description</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th>
        </tr>
        <?php if ($result->num_rows === 0): ?>
            <tr><td colspan="6">No products yet. Add your first one.</td></tr>
        <?php endif; ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td>GH₵ <?php echo number_format($row['price'], 2); ?></td>
            <td><?php echo (int)$row['stock']; ?></td>
            <td><span class="badge <?php echo $row['status']; ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
            <td>
                <a href="edit.php?id=<?php echo (int)$row['id']; ?>">Edit</a>
                <form class="inline" method="POST" action="delete.php"
                      onsubmit="return confirm('Delete this product?');">
                    <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>
