<?php
// Admin base layout
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ADMIN GLOBAL CSS -->
    <link rel="stylesheet" href="../static/css/admin/admin.css">

    <!-- PAGE SPECIFIC CSS -->
    <?php if (isset($extra_css)) echo $extra_css; ?>

    <title><?php echo isset($title) ? $title : "Admin Panel"; ?></title>

    <!-- ICONS (Font Awesome) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<div class="admin-container">
    
    <!-- SIDEBAR NAVIGATION -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h1 class="sidebar-title">6ixe7ven</h1>
            <p class="sidebar-subtitle">Admin Panel</p>
        </div>
        
        <nav>
            <ul class="sidebar-menu">
                <li>
                    <a href="dashboard.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="products.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'products.php') ? 'active' : ''; ?>">
                        <i class="fas fa-box"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="orders.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'orders.php') ? 'active' : ''; ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li>
                    <a href="users.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'users.php') ? 'active' : ''; ?>">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="banners.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'banners.php') ? 'active' : ''; ?>">
                        <i class="fas fa-image"></i>
                        <span>Banners</span>
                    </a>
                </li>
                <li>
                    <a href="settings.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'settings.php') ? 'active' : ''; ?>">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="logout-section">
            <ul class="sidebar-menu">
                <li>
                    <a href="logout.php" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="admin-main">
        <?php 
            // PRINT PAGE CONTENT
            if (isset($content)) echo $content; 
        ?>
    </main>

</div>

<!-- PAGE SPECIFIC JS -->
<?php if (isset($extra_js)) echo $extra_js; ?>

</body>
</html>