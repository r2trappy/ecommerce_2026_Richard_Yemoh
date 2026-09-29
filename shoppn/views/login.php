<?php require_once __DIR__ . '/../core/core.php'; ?>
<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="form-page">
    <h2>Login</h2>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form id="login-form" action="<?php echo base_url(); ?>actions/login_action.php" method="POST" novalidate>
        <label>Email</label>
        <input type="email" name="email" id="login-email" required>
        <span class="field-error" id="login-email-error"></span>

        <label>Password</label>
        <input type="password" name="pass" id="login-pass" required>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="<?php echo base_url(); ?>views/register.php">Register</a></p>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
