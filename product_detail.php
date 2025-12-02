<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$title = "Product Details";

$extra_css = '
<link rel="stylesheet" href="/E-Commerce-Project/static/css/product_details.css">
';

$extra_js = '
<script src="/E-Commerce-Project/static/js/cart.js"></script>
<script src="/E-Commerce-Project/static/js/product_zoom.js"></script>
';

$product_id = $_GET['id'] ?? null;

// In real DB version: fetch using SQL
$products = [
    "hoodie1" => [
        "name" => "6ixe7ven Hoodie 1",
        "price" => "39.99",
        "image" => "/E-Commerce-Project/static/images/hoodie1.jpeg"
    ],
    "hoodie2" => [
        "name" => "6ixe7ven Hoodie 2",
        "price" => "39.99",
        "image" => "/E-Commerce-Project/static/images/hoodie2.jpeg"
    ],
    "hoodie3" => [
        "name" => "6ixe7ven Hoodie 3",
        "price" => "49.99",
        "image" => "/E-Commerce-Project/static/images/hoodie3.jpeg"
    ],
];

$product = $products[$product_id] ?? null;

ob_start();
?>

<?php if (!$product): ?>
    <h2>Product not found.</h2>
<?php else: ?>

<div class="product-detail-container">

    <div class="product-detail-image">
        <img class="zoom-trigger"
             src="<?= $product['image'] ?>"
             data-full="<?= $product['image'] ?>">
    </div>

    <div class="product-detail-info">
        <h2><?= $product['name'] ?></h2>
        <p class="price">£<?= $product['price'] ?></p>

        <button class="add-btn"
            data-id="<?= $product_id ?>"
            data-name="<?= $product['name'] ?>"
            data-price="<?= $product['price'] ?>"
            data-image="<?= $product['image'] ?>">
            Add to Cart
        </button>
    </div>

</div>

<!-- UNIVERSAL ZOOM MODAL -->
<div id="zoomModal" class="zoom-modal">
    <span class="close-zoom">&times;</span>
    <img id="zoomImage" class="zoom-modal-content">
</div>

<?php endif; ?>

<?php
$content = ob_get_clean();
include "base.php";
?>
