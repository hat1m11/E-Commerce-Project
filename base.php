<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- GLOBAL CSS -->
    <link rel="stylesheet" href="/static/css/base.css">

    <!-- PAGE-SPECIFIC CSS -->
    <?php if (isset($extra_css)) echo $extra_css; ?>

    <title><?php echo isset($title) ? $title : "6ixe7ven"; ?></title>

    <!-- ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <!-- NAVBAR -->
    <header class="navbar">

        <!-- LOGO -->
        <div class="logo-container">
            <img src="/static/images/6ixe7venLogo.png" 
                 alt="6ixe7ven Logo" 
                 class="logo-img">
            <span class="logo-text">6ixe7ven</span>
        </div>

        <!-- SEARCH BAR -->
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

        <!-- NAV LINKS -->
        <nav>
            <a href="/index.php">Home</a>
            <a href="/login.php">Login</a>
            <a href="/basket.php">Cart</a>
            <a class="contact-text" href="/contact.php">Contact Us</a>
        </nav>

    </header>

    <!-- MAIN CONTENT -->
    <main>
        <?php 
        // This prints the page content included by child pages
        if (isset($content)) echo $content; 
        ?>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <p>© 2025 Project 67. All rights reserved.</p>
    </footer>

    <!-- PAGE-SPECIFIC JS -->
    <?php if (isset($extra_js)) echo $extra_js; ?>

</body>
</html>
