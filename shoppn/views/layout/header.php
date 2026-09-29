<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoppn</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
</head>
<body>
<header class="site-header">
    <div class="logo"><a href="<?php echo base_url(); ?>index.php">Shoppn</a></div>

    <form class="search-form" action="<?php echo base_url(); ?>views/search_results.php" method="GET">
        <input type="text" name="user_query" placeholder="Search products...">
        <button type="submit">Search</button>
    </form>

    <nav class="main-nav">
        <?php if (is_admin()): ?>
            <a href="<?php echo base_url(); ?>views/admin/brand.php">Brands</a>
            <a href="<?php echo base_url(); ?>views/admin/category.php">Categories</a>
            <a href="<?php echo base_url(); ?>views/admin/product.php">Products</a>
        <?php endif; ?>

        <?php if (is_logged_in()): ?>
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['customer_name']); ?></span>
            <a href="<?php echo base_url(); ?>views/account/my_account.php">My Account</a>
            <a href="<?php echo base_url(); ?>logout.php">Logout</a>
        <?php else: ?>
            <a href="<?php echo base_url(); ?>views/register.php">Register</a>
            <a href="<?php echo base_url(); ?>views/login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
<main class="site-main">
