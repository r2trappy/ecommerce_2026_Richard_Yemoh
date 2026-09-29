<?php require_once __DIR__ . '/../core/core.php'; ?>
<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="form-page">
    <h2>Create an Account</h2>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form id="register-form" action="<?php echo base_url(); ?>actions/register_action.php" method="POST" novalidate>
        <label>Full Name</label>
        <input type="text" name="name" id="name" required>
        <span class="field-error" id="name-error"></span>

        <label>Email</label>
        <input type="email" name="email" id="email" required>
        <span class="field-error" id="email-error"></span>

        <label>Password</label>
        <input type="password" name="pass" id="pass" required>
        <span class="field-error" id="pass-error"></span>

        <label>Country</label>
        <select name="country" id="country">
            <option value="Ghana">Ghana</option>
            <option value="Nigeria">Nigeria</option>
            <option value="Other">Other</option>
        </select>

        <label>City</label>
        <input type="text" name="city" id="city">

        <label>Contact Number</label>
        <input type="text" name="contact" id="contact">
        <span class="field-error" id="contact-error"></span>

        <button type="submit" id="register-submit">Register</button>
    </form>

    <p>Already have an account? <a href="<?php echo base_url(); ?>views/login.php">Login</a></p>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
