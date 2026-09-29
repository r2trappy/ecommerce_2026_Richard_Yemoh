<?php require_once __DIR__ . '/../../core/core.php'; ?>
<?php require_login(); ?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="account-page">
    <h2>My Account</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['customer_name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['customer_email']); ?></p>
    <p><a href="<?php echo base_url(); ?>logout.php">Logout</a></p>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
