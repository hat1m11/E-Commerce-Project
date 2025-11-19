<?php
$title = "Product Details - 6ixe7ven";
$extra_css = '<link rel="stylesheet" href="/static/css/product_details.css">';
ob_start();
?>

<div class="product-wrapper">

    <div class="product-image">
        <img src="/static/images/products/sample_product.jpg" alt="Product Image">
    </div>

    <div class="product-info">

        <h1 class="product-title">Men's Overcoat</h1>

        <p class="product-price">£120.00</p>

        <p class="product-description">
            A premium-quality winter overcoat designed for comfort, style, 
            and warmth. Perfect for cold weather and everyday wear.
        </p>

        <label for="size" class="size-label">Select Size:</label>
        <select id="size" class="size-select">
            <option>S</option>
            <option>M</option>
            <option>L</option>
            <option>XL</option>
        </select>

        <button class="add-cart-btn">Add to Cart</button>

    </div>

</div>

<?php
$content = ob_get_clean();
include "base.php";
?>
