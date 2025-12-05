<?php
$title = "Products - 6ixe7ven"; // page title

$extra_css = '<link rel="stylesheet" href="css/products.css">'; // page css

ob_start(); // start content
?>

<h1 class="products-title">Our Products</h1>

<div class="products-grid">

    <div class="product-card">
        <img src="images/products/sample1.jpg" alt="Product">
        <h3>Men's Overcoat</h3>
        <p class="price">£120.00</p>
        <a href="product_details.php?product=hoodie1" class="view-btn">View Details</a>
    </div>

    <div class="product-card">
        <img src="images/products/sample2.jpg" alt="Product">
        <h3>Women's Jacket</h3>
        <p class="price">£98.00</p>
        <a href="product_details.php?product=hoodie2" class="view-btn">View Details</a>
    </div>

    <div class="product-card">
        <img src="images/products/sample3.jpg" alt="Product">
        <h3>Kids Sneakers</h3>
        <p class="price">£45.00</p>
        <a href="product_details.php?product=hoodie3" class="view-btn">View Details</a>
    </div>

    <div class="product-card">
        <img src="images/products/sample4.jpg" alt="Product">
        <h3>Women's Handbag</h3>
        <p class="price">£60.00</p>
        <a href="product_details.php" class="view-btn">View Details</a>
    </div>

</div>

<?php
$content = ob_get_clean(); // grab content
include "base.php"; // load layout
?>

