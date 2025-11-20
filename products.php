<?php
$title = "Products - 6ixe7ven";

// FIXED CSS PATH
$extra_css = '<link rel="stylesheet" href="static/css/products.css">';

ob_start();
?>

<h1 class="products-title">Our Products</h1>

<div class="products-grid">

    <!-- Product 1 -->
    <div class="product-card">
        <img src="static/images/products/sample1.jpg" alt="Product">
        <h3>Men's Overcoat</h3>
        <p class="price">£120.00</p>
        <a href="product_details.php" class="view-btn">View Details</a>
    </div>

    <!-- Product 2 -->
    <div class="product-card">
        <img src="static/images/products/sample2.jpg" alt="Product">
        <h3>Women's Jacket</h3>
        <p class="price">£98.00</p>
        <a href="product_details.php" class="view-btn">View Details</a>
    </div>

    <!-- Product 3 -->
    <div class="product-card">
        <img src="static/images/products/sample3.jpg" alt="Product">
        <h3>Kids Sneakers</h3>
        <p class="price">£45.00</p>
        <a href="product_details.php" class="view-btn">View Details</a>
    </div>

    <!-- Product 4 -->
    <div class="product-card">
        <img src="static/images/products/sample4.jpg" alt="Product">
        <h3>Women's Handbag</h3>
        <p class="price">£60.00</p>
        <a href="product_details.php" class="view-btn">View Details</a>
    </div>

</div>

<?php
$content = ob_get_clean();
include "base.php";
?>
