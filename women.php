<?php
include_once "config.php";

$title  = "Women's Products";

// PAGE CSS
$extra_css = '<link rel="stylesheet" href="' . $BASE_URL . '/static/css/women.css">';

$extra_js  = 
    '<script>window.BASE_URL = "' . $BASE_URL . '";</script>' .
    '<script src="' . $BASE_URL . '/static/js/cart.js"></script>' .
    '<script src="' . $BASE_URL . '/static/js/women.js"></script>';

ob_start();
?>

<section class="products-header">
    <h1>Women's Collection</h1>

    <!-- Filter + Sort -->
    <div class="controls-wrapper">

        <div class="filters">
            <label for="typeFilter">Filter by Type:</label>
            <select id="typeFilter" class="control-select">
                <option value="All">All</option>
                <option value="Hoodie">Hoodies</option>
                <option value="Jeans">Jeans</option>
                <option value="T-shirt">T-shirts</option>
            </select>
        </div>

        <div class="sort">
            <label for="sortSelect">Sort by:</label>
            <select id="sortSelect" class="control-select">
                <option value="">Sort by:</option>
                <option value="newest">Newest</option>
                <option value="priceLow">Price: Low to High</option>
                <option value="priceHigh">Price: High to Low</option>
            </select>
        </div>

    </div>
</section>

<!-- Products Grid -->
<section class="products-grid">
    <!-- These initial cards are fine â€“ JS will overwrite them when it runs -->

    <div class="product-card">
        <img src="<?php echo $BASE_URL; ?>/static/images/hoodie4.jpeg" alt="6ixe7even Hoodie Womens 1">
        <h3>6ixe7even Hoodie 1</h3>
        <p class="price">Â£39.99</p>
        <button class="add-btn"
            data-id="w_hoodie1"
            data-name="6ixe7even Hoodie Womens 1"
            data-price="39.99"
            data-image="<?php echo $BASE_URL; ?>/static/images/hoodie4.jpeg">
            Add to Cart
        </button>
    </div>

    <div class="product-card">
        <img src="<?php echo $BASE_URL; ?>/static/images/jeans1.jpeg" alt="6ixe7even Jeans Womens 1">
        <h3>6ixe7even Jeans 1</h3>
        <p class="price">Â£49.99</p>
        <button class="add-btn"
            data-id="w_jeans1"
            data-name="6ixe7even Jeans Womens 1"
            data-price="49.99"
            data-image="<?php echo $BASE_URL; ?>/static/images/jeans1.jpeg">
            Add to Cart
        </button>
    </div>

    <div class="product-card">
        <img src="<?php echo $BASE_URL; ?>/static/images/tshirt1.jpeg" alt="6ixe7even T-shirt Womens 1">
        <h3>6ixe7even T-shirt 1</h3>
        <p class="price">Â£19.99</p>
        <button class="add-btn"
            data-id="w_tshirt1"
            data-name="6ixe7even T-shirt Womens 1"
            data-price="19.99"
            data-image="<?php echo $BASE_URL; ?>/static/images/tshirt1.jpeg">
            Add to Cart
        </button>
    </div>

    <div class="product-card">
        <img src="<?php echo $BASE_URL; ?>/static/images/hoodie5.jpeg" alt="6ixe7even Hoodie Womens 2">
        <h3>6ixe7even Hoodie 2</h3>
        <p class="price">Â£39.99</p>
        <button class="add-btn"
            data-id="w_hoodie2"
            data-name="6ixe7even Hoodie Womens 2"
            data-price="39.99"
            data-image="<?php echo $BASE_URL; ?>/static/images/hoodie5.jpeg">
            Add to Cart
        </button>
    </div>

    <div class="product-card">
        <img src="<?php echo $BASE_URL; ?>/static/images/tshirt2.jpeg" alt="6ixe7even T-shirt Womens 2">
        <h3>6ixe7even T-shirt 2</h3>
        <p class="price">Â£19.99</p>
        <button class="add-btn"
            data-id="w_tshirt2"
            data-name="6ixe7even T-shirt Womens 2"
            data-price="19.99"
            data-image="<?php echo $BASE_URL; ?>/static/images/tshirt2.jpeg">
            Add to Cart
        </button>
    </div>

</section>

<?php
$content = ob_get_clean();
include "base.php";
?>


