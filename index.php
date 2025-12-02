<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$title = "Home - 6ixe7ven";

$extra_css = '
<link rel="stylesheet" href="/E-Commerce-Project/static/css/index.css">
<link rel="stylesheet" href="/E-Commerce-Project/static/css/product_details.css">
';

$extra_js = '
<script src="/E-Commerce-Project/static/js/bannerSlide.js"></script>
<script src="/E-Commerce-Project/static/js/cart.js"></script>
<script src="/E-Commerce-Project/static/js/product_zoom.js"></script>
';

ob_start();
?>

<section class="banner">
    <div class="rotation">
        <img src="/E-Commerce-Project/static/images/banner/banner1.png" class="rotation-image active">
        <img src="/E-Commerce-Project/static/images/banner/banner2.jpg" class="rotation-image">
        <img src="/E-Commerce-Project/static/images/banner/banner3.jpg" class="rotation-image">

        <button class="banner-arrow banner-prev">&#8249;</button>
        <button class="banner-arrow banner-next">&#8250;</button>

        <div class="banner-indicators">
            <span class="banner-indicator active"></span>
            <span class="banner-indicator"></span>
            <span class="banner-indicator"></span>
        </div>
    </div>
</section>

<section class="product-section">
    <h2 class="section-title">Featured Products</h2>

    <div class="product-grid">

        <div class="product-card">
            <img class="zoom-trigger"
                 src="/E-Commerce-Project/static/images/hoodie1.jpeg"
                 data-full="/E-Commerce-Project/static/images/hoodie1.jpeg">

            <h3>6ixe7ven Hoodie 1</h3>
            <p class="price">£39.99</p>

            <button class="add-btn"
                data-id="hoodie1"
                data-name="6ixe7ven Hoodie 1"
                data-price="39.99"
                data-image="/E-Commerce-Project/static/images/hoodie1.jpeg">
                Add to Cart
            </button>
        </div>

        <div class="product-card">
            <img class="zoom-trigger"
                 src="/E-Commerce-Project/static/images/hoodie2.jpeg"
                 data-full="/E-Commerce-Project/static/images/hoodie2.jpeg">

            <h3>6ixe7ven Hoodie 2</h3>
            <p class="price">£39.99</p>

            <button class="add-btn"
                data-id="hoodie2"
                data-name="6ixe7ven Hoodie 2"
                data-price="39.99"
                data-image="/E-Commerce-Project/static/images/hoodie2.jpeg">
                Add to Cart
            </button>
        </div>

        <div class="product-card">
            <img class="zoom-trigger"
                 src="/E-Commerce-Project/static/images/hoodie3.jpeg"
                 data-full="/E-Commerce-Project/static/images/hoodie3.jpeg">

            <h3>6ixe7ven Hoodie 3</h3>
            <p class="price">£49.99</p>

            <button class="add-btn"
                data-id="hoodie3"
                data-name="6ixe7ven Hoodie 3"
                data-price="49.99"
                data-image="/E-Commerce-Project/static/images/hoodie3.jpeg">
                Add to Cart
            </button>
        </div>

    </div>
</section>

<!-- UNIVERSAL ZOOM MODAL -->
<div id="zoomModal" class="zoom-modal">
    <span class="close-zoom">&times;</span>
    <img id="zoomImage" class="zoom-modal-content">
</div>

<?php
$content = ob_get_clean();
include "base.php";
?>
