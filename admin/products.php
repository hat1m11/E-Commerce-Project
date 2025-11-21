<?php
session_start();

// ADMIN PROTECTION
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

$title = "Manage Products";

// PAGE-SPECIFIC CSS
$extra_css = '<link rel="stylesheet" href="../static/css/admin/adminProducts.css">';

ob_start();
?>

<div class="content-header">
    <h1 class="page-title">Products</h1>
    <p class="page-subtitle">Manage and update your store products</p>

    <a href="add_product.php" class="btn btn-primary add-btn">
        <i class="fas fa-plus"></i> Add New Product
    </a>
</div>

<div class="admin-table-container">

    <div class="table-header">
        <h2 class="table-title">Product List</h2>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price (£)</th>
                <th>Stock</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <!-- SAMPLE DATA (Later replaced with DB data) -->
            <tr>
                <td>1</td>
                <td><img src="../static/images/products/sample1.jpg" class="product-thumb"></td>
                <td>Men's Overcoat</td>
                <td>120.00</td>
                <td>34</td>
                <td>Men</td>
                <td>
                    <a href="edit_product.php?id=1" class="btn btn-secondary">Edit</a>
                    <a href="delete_product.php?id=1" class="btn btn-danger">Delete</a>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td><img src="../static/images/products/sample2.jpg" class="product-thumb"></td>
                <td>Women's Jacket</td>
                <td>98.00</td>
                <td>12</td>
                <td>Women</td>
                <td>
                    <a href="edit_product.php?id=2" class="btn btn-secondary">Edit</a>
                    <a href="delete_product.php?id=2" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        </tbody>

    </table>

</div>

<?php
$content = ob_get_clean();
include "adminBase.php";
?>
