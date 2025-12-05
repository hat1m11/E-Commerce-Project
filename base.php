<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- GLOBAL CSS -->
    <link rel="stylesheet" href="<?= $BASE_URL ?>/css/base.css">

    <!-- PAGE-SPECIFIC CSS -->
    <?php 
        if (isset($extra_css)) echo $extra_css;
    ?>

    <title><?= isset($title) ? $title : "6ixe7ven"; ?></title>

    <!-- ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <!-- NAVBAR -->
    <header class="navbar">

        <div class="logo-container">
            <img src="<?= $BASE_URL ?>/images/6ixe7venLogo.png" 
                 alt="6ixe7ven Logo" class="logo-img">
            <span class="logo-text">6ixe7ven</span>
        </div>

        <div class="search-bar">
            <select class="category-select">
                <option value="">All</option>
                <option value="men">Men</option>
                <option value="women">Women</option>
                <option value="children">Children</option>
                <option value="shoes">Shoes</option>
                <option value="accessories">Accessories</option>
            </select>

            <input type="text" placeholder="Search products...">

            <button class="search-btn">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>

        <nav>
            <!-- Your teammate removed this dynamic logic; we restore it -->
            <a href="<?= $BASE_URL ?>/<?= isset($_SESSION['user_id']) ? 'dashboard.php' : 'index.php' ?>">
                Home
            </a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?= $BASE_URL ?>/logout.php">Logout</a>
                <span class="welcome-text">Hi, <?= htmlspecialchars($_SESSION['username']); ?></span>
            <?php else: ?>
                <a href="<?= $BASE_URL ?>/login.php">Login</a>
            <?php endif; ?>

            <a href="<?= $BASE_URL ?>/cart.php">Cart</a>
            <a class="contact-text" href="<?= $BASE_URL ?>/contact.php">Contact Us</a>
        </nav>

    </header>

    <!-- MAIN CONTENT -->
    <main>
        <?php if (isset($content)) echo $content; ?>
    </main>

    <!-- FOOTER -->
    <footer class="footer">

        <div class="footer-container">

            <!-- Logo -->
            <div class="footer-logo">
                <img src="<?= $BASE_URL ?>/images/6ixe7venLogo.png" class="footer-logo-img">
                <span class="footer-text">6ixe7ven</span>
            </div>

            <!-- Quick links -->
            <nav class="footer-links">
                <a href="<?= $BASE_URL ?>/about.php">About Us</a>
                <a href="<?= $BASE_URL ?>/contact.php">Contact</a>
                <a href="<?= $BASE_URL ?>/products.php">Shop</a>
            </nav>

            <!-- Payment icons -->
            <div class="footer-payments">
                <i class="fa-brands fa-cc-visa"></i>
                <i class="fa-brands fa-cc-mastercard"></i>
                <i class="fa-brands fa-cc-paypal"></i>
            </div>

        </div>

        <p class="footer-copy">© 2025 6ixe7ven. All rights reserved.</p>
    </footer>

    <!-- PAGE-SPECIFIC JS -->
    <?php if (isset($extra_js)) echo $extra_js; ?>

</body>
</html>
