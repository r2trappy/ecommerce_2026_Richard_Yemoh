<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

$controller = new CartController();
$items = $controller->getCartItems(get_ip());
$subtotal = $controller->getCartTotal(get_ip());
?>
<?php require_once __DIR__ . '/layout/header.php'; ?>
<?php require_once __DIR__ . '/layout/sidebar.php'; ?>

<section class="home-content">
    <h1>Your Cart</h1>

    <?php if (empty($items)): ?>
        <p>Your cart is empty.</p>
        <p><a class="btn-link" href="<?php echo base_url(); ?>index.php">Continue Shopping</a></p>
    <?php else: ?>
        <form id="remove-form" action="<?php echo base_url(); ?>actions/remove_from_cart_action.php" method="POST"></form>
        <form id="update-form" action="<?php echo base_url(); ?>actions/update_qty_action.php" method="POST"></form>

        <table class="data-table cart-table">
            <tr>
                <th>Remove</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Line Total</th>
            </tr>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td>
                        <input type="checkbox" form="remove-form" name="remove[]" value="<?php echo (int)$item['p_id']; ?>">
                    </td>
                    <td>
                        <?php if (!empty($item['product_image'])): ?>
                            <img class="cart-thumb" src="<?php echo base_url(); ?>images/products/<?php echo htmlspecialchars(rawurlencode($item['product_image'])); ?>" alt="">
                        <?php endif; ?>
                        <a href="<?php echo base_url(); ?>views/single_product.php?pro_id=<?php echo (int)$item['p_id']; ?>"><?php echo htmlspecialchars($item['product_title']); ?></a>
                    </td>
                    <td>
                        <input type="text" form="update-form" class="qty-input" name="qty[]" value="<?php echo (int)$item['qty']; ?>" inputmode="numeric" maxlength="2" size="3">
                        <input type="hidden" form="update-form" name="update[]" value="<?php echo (int)$item['p_id']; ?>">
                    </td>
                    <td>GH₵ <?php echo number_format((float)$item['product_price'], 2); ?></td>
                    <td>GH₵ <?php echo number_format((int)$item['qty'] * (float)$item['product_price'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4"><strong>Subtotal</strong></td>
                <td><strong>GH₵ <?php echo number_format($subtotal, 2); ?></strong></td>
            </tr>
        </table>

        <p class="cart-buttons">
            <button type="submit" form="remove-form">Remove from Cart</button>
            <button type="submit" form="update-form" id="update-qty-btn">Update Quantity</button>
            <span class="field-error" id="qty-error"></span>
        </p>
        <p class="cart-buttons">
            <a class="btn-link" href="<?php echo base_url(); ?>index.php">Continue Shopping</a>
            <a class="btn-link" href="<?php echo base_url(); ?>views/checkout.php">Checkout</a>
        </p>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
