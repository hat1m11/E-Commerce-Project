<?php
// Start session if it's not already running
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Main site CSS (direct path) -->
    <link rel="stylesheet" href="base.css">

    <!-- Extra CSS injected by product pages -->
    <?php 
        if (isset($extra_css)) {
            echo $extra_css; 
        }
    ?>

    <title><?= isset($title) ? $title : "6ixe7ven"; ?></title>

    <!-- Icons -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<header class="navbar">

    <!-- Logo -->
    <div class="logo-container">
        <img src="images/6ixe7venLogo.png" alt="6ixe7ven Logo" class="logo-img">
        <span class="logo-text">6ixe7ven</span>
    </div>

    <!-- Navigation -->
    <nav>
        <a href="<?= isset($_SESSION['user_id']) ? 'dashboard.php' : 'index.php'; ?>">
            Home
        </a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php">Logout</a>
            <span class="welcome-text">Hi, <?= htmlspecialchars($_SESSION['username']); ?></span>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>

        <!-- Correct direct links -->
        <a href="men.php" class="cat-link">Men's</a>
        <a href="women.php" class="cat-link">Women's</a>

        <a href="cart.php">Cart</a>
        <a class="contact-text" href="contact.php">Contact Us</a>
    </nav>

</header>

<!-- Main Content -->
<main>
    <?php if (isset($content)) echo $content; ?>
</main>

<!-- Footer -->
<footer class="footer">
    <p>© 2025 6ixe7ven. All rights reserved.</p>
</footer>

<!-- Extra JS injected by product pages -->
<?php 
    if (isset($extra_js)) {
        echo $extra_js;
    }
?>

</body>
</html>
