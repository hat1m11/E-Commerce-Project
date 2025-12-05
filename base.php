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

    <!-- Main site CSS -->
    <link rel="stylesheet" href="static/css/base.css">

    <!-- Extra CSS for specific pages -->
    <?php 
        if (isset($extra_css)) echo $extra_css;
    ?>

    <title><?= isset($title) ? $title : "6ixe7ven"; ?></title>

    <!-- Icons (Font Awesome) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <!-- Site navbar -->
    <header class="navbar">

        <!-- Logo -->
        <div class="logo-container">
            <img src="static/images/6ixe7venLogo.png" alt="6ixe7ven Logo" class="logo-img">
            <span class="logo-text">6ixe7ven</span>
        </div>

        <!-- Search bar -->
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

        <!-- Navigation links -->
        <nav>
            <!-- Home link changes depending on login -->
            <a href="<?php echo isset($_SESSION['user_id']) ? 'dashboard.php' : 'index.php'; ?>">
                Home
            </a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- If user is logged in -->
                <a href="logout.php">Logout</a>
                <span class="welcome-text">Hi, <?= htmlspecialchars($_SESSION['username']); ?></span>
            <?php else: ?>
                <!-- If user is not logged in -->
                <a href="login.php">Login</a>
            <?php endif; ?>

            <a href="cart.php">Cart</a>
            <a class="contact-text" href="contact.php">Contact Us</a>
        </nav>

</header>

    <!-- Main page content -->
    <main>
        <?php if (isset($content)) echo $content; ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>© 2025 Project 67. All rights reserved.</p>
    </footer>

    <!-- Page-specific JavaScript -->
    <?php if (isset($extra_js)) echo $extra_js; ?>

</body>
</html>
