<?php
session_start();
include "connection.php"; // connect to DB

// redirect user if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// page settings
$title = "Dashboard - 6ixe7ven";
$extra_css = '<link rel="stylesheet" href="static/css/index.css">';
$extra_js = <<<EOT
<script src="js/bannerSlide.js"></script>
<script src="js/cart.js"></script>
EOT;

// start capturing page output
ob_start();
?>

<!-- Banner slider -->
<section class="banner">
    <div class="rotation">
        <img src="images/banner/banner1.png" class="rotation-image active">
        <img src="images/banner/banner2.jpg" class="rotation-image">
        <img src="images/banner/banner3.jpg" class="rotation-image">

        <button class="banner-arrow banner-prev">&#8249;</button>
        <button class="banner-arrow banner-next">&#8250;</button>

        <div class="banner-indicators">
            <span class="banner-indicator active"></span>
            <span class="banner-indicator"></span>
            <span class="banner-indicator"></span>
        </div>
    </div>
</section>

<!-- Product section -->
<section class="product-section">
    <h2 class="section-title">Welcome, <?= htmlspecialchars($_SESSION['full_name']); ?>!</h2>

    <div class="product-grid">

        <div class="product-card">
            <img src="images/hoodie1.jpeg" alt="6ixe7ven Hoodie 1">
            <h3>6ixe7ven Hoodie 1</h3>
            <p class="price">£39.99</p>
            <button class="add-btn"
                data-id="1"
                data-name="6ixe7ven Hoodie 1"
                data-price="39.99"
                data-image="images/hoodie1.jpeg">
                Add to Cart
            </button>
        </div>

        <div class="product-card">
            <img src="images/hoodie2.jpeg" alt="6ixe7ven Hoodie 2">
            <h3>6ixe7ven Hoodie 2</h3>
            <p class="price">£39.99</p>
            <button class="add-btn"
                data-id="2"
                data-name="6ixe7ven Hoodie 2"
                data-price="39.99"
                data-image="images/hoodie2.jpeg">
                Add to Cart
            </button>
        </div>

        <div class="product-card">
            <img src="images/hoodie3.jpeg" alt="6ixe7ven Hoodie 3">
            <h3>6ixe7ven Hoodie 3</h3>
            <p class="price">£49.99</p>
            <button class="add-btn"
                data-id="3"
                data-name="6ixe7ven Hoodie 3"
                data-price="49.99"
                data-image="images/hoodie3.jpeg">
                Add to Cart
            </button>
        </div>

    </div>
</section>

<!-- Quick link to cart -->
<a href="cart.php" class="auth-btn">View Cart</a>

<?php
// finish capturing page content
$content = ob_get_clean();

// load main layout
include "base.php";
?>
