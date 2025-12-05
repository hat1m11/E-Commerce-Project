<?php
$title = "Product Details - 6ixe7ven";
$extra_css = '<link rel="stylesheet" href="/E-Commerce-Project/static/css/product_details.css">';
$extra_js  = '<script src="/E-Commerce-Project/static/js/product_zoom.js"></script>';

$product = $_GET['product'] ?? null;

// Mock product data (later you can pull this from MySQL)
$products = [
    "hoodie1" => [
        "name" => "6ixe7ven Hoodie 1",
        "price" => "39.99",
        "image" => "/E-Commerce-Project/static/images/hoodie1.jpeg",
        "description" => "Premium cotton hoodie with modern fit."
    ],
    "hoodie2" => [
        "name" => "6ixe7ven Hoodie 2",
        "price" => "39.99",
        "image" => "/E-Commerce-Project/static/images/hoodie2.jpeg",
        "description" => "Soft fleece-lined hoodie, perfect for cold days."
    ],
    "hoodie3" => [
        "name" => "6ixe7ven Hoodie 3",
        "price" => "49.99",
        "image" => "/E-Commerce-Project/static/images/hoodie3.jpeg",
        "description" => "Limited edition hoodie with luxury fabric."
    ]
];

// If the product doesn't exist → show 404
if (!$product || !isset($products[$product])) {
    die("Product not found.");
}

$p = $products[$product];

ob_start(); // start content
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

<!-- ZOOM MODAL -->
<div id="zoomModal" class="zoom-modal">
    <span class="close-zoom">&times;</span>
    <img id="zoomImage" class="zoom-modal-content">
</div>

<?php endif; ?>

<?php
$content = ob_get_clean(); // grab content
include "base.php"; // load layout
?>
