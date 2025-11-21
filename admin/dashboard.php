<?php
session_start();

// ADMIN PROTECTION
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

$title = "Admin Dashboard - 6ixe7ven";

// PAGE-SPECIFIC CSS
$extra_css = '<link rel="stylesheet" href="../static/css/admin.css">';

ob_start();
?>

<div class="admin-container">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h2 class="sidebar-title">Admin Panel</h2>

        <ul class="sidebar-menu">
            <li><a href="dashboard.php" class="active">Dashboard</a></li>
            <li><a href="add_product.php">Add Product</a></li>
            <li><a href="edit_product.php">Edit Products</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="../logout.php" class="logout-btn">Logout</a></li>
        </ul>
    </aside>

    <!-- MAIN DASHBOARD CONTENT -->
    <main class="admin-main">
        <h1 class="page-title">Dashboard</h1>

        <div class="admin-cards">
            <div class="card">
                <h3>Total Products</h3>
                <p>54</p>
            </div>

            <div class="card">
                <h3>Total Orders</h3>
                <p>128</p>
            </div>

            <div class="card">
                <h3>Pending Orders</h3>
                <p>7</p>
            </div>

            <div class="card">
                <h3>Registered Users</h3>
                <p>342</p>
            </div>
        </div>
    </main>

</div>

<?php
$content = ob_get_clean();
include "adminBase.php";
?>
