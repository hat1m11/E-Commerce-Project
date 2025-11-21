<?php
session_start();

// ADMIN PROTECTION
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

$title = "Banners";

// PAGE-SPECIFIC CSS
$extra_css = '<link rel="stylesheet" href="../static/css/admin/adminBanners.css">';

ob_start();
?>

<div class="content-header">
    <h1 class="page-title">Banners</h1>
    <p class="page-subtitle">Manage homepage banners and promotional graphics</p>

    <a href="add_banner.php" class="btn btn-primary add-btn">
        <i class="fas fa-plus"></i> Add New Banner
    </a>
</div>

<div class="admin-table-container">

    <div class="table-header">
        <h2 class="table-title">Banner List</h2>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Preview</th>
                <th>Title</th>
                <th>Position</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

            <!-- SAMPLE DATA – replace with DB later -->
            <tr>
                <td>1</td>
                <td>
                    <img src="../static/images/banner/banner1.png" class="banner-thumb">
                </td>
                <td>Winter Sale</td>
                <td>1</td>
                <td><span class="status status-active">Active</span></td>
                <td>
                    <a href="edit_banner.php?id=1" class="btn btn-secondary">Edit</a>
                    <a href="delete_banner.php?id=1" class="btn btn-danger">Delete</a>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td>
                    <img src="../static/images/banner/banner2.jpg" class="banner-thumb">
                </td>
                <td>New Arrivals</td>
                <td>2</td>
                <td><span class="status status-hidden">Hidden</span></td>
                <td>
                    <a href="edit_banner.php?id=2" class="btn btn-secondary">Edit</a>
                    <a href="delete_banner.php?id=2" class="btn btn-danger">Delete</a>
                </td>
            </tr>

        </tbody>

    </table>

</div>

<?php
$content = ob_get_clean();
include "adminBase.php";
?>
