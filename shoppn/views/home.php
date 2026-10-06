<?php
require_once __DIR__ . '/layout/header.php';
require_once __DIR__ . '/layout/sidebar.php';
?>
<div class="home-content">
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <h1>Welcome to Shoppn</h1>
    <p>Browse categories and brands in the sidebar.</p>
</div>
<?php require_once __DIR__ . '/layout/footer.php'; ?>
