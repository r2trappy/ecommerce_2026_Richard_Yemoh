<div class="product-card">
    <a href="<?php echo base_url(); ?>views/single_product.php?pro_id=<?php echo (int)$product['product_id']; ?>">
        <?php if (!empty($product['product_image'])): ?>
            <img src="<?php echo base_url(); ?>images/products/<?php echo htmlspecialchars(rawurlencode($product['product_image'])); ?>" alt="<?php echo htmlspecialchars($product['product_title']); ?>">
        <?php else: ?>
            <div class="no-image">No image</div>
        <?php endif; ?>
    </a>
    <h3><?php echo htmlspecialchars($product['product_title']); ?></h3>
    <p class="price">GH₵ <?php echo number_format((float)$product['product_price'], 2); ?></p>
    <p>
        <a class="btn-link" href="<?php echo base_url(); ?>views/single_product.php?pro_id=<?php echo (int)$product['product_id']; ?>">Details</a>
        <a class="btn-link" href="<?php echo base_url(); ?>actions/add_to_cart_action.php?add_cart=<?php echo (int)$product['product_id']; ?>">Add to Cart</a>
    </p>
</div>
