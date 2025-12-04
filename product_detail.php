<?php
$title = "Product Details - 6ixe7ven"; // page title

$extra_css = '<link rel="stylesheet" href="css/product_details.css">'; // css file
$extra_js  = '<script src="js/product_zoom.js"></script>'; // zoom script

$product = $_GET['product'] ?? null; // get product key

$products = [
    "hoodie1" => [
        "name" => "6ixe7ven Hoodie 1",
        "price" => "39.99",
        "image" => "images/hoodie1.jpeg",
        "description" => "Premium cotton hoodie with modern fit."
    ],
    "hoodie2" => [
        "name" => "6ixe7ven Hoodie 2",
        "price" => "39.99",
        "image" => "images/hoodie2.jpeg",
        "description" => "Soft fleece-lined hoodie, perfect for cold days."
    ],
    "hoodie3" => [
        "name" => "6ixe7ven Hoodie 3",
        "price" => "49.99",
        "image" => "images/hoodie3.jpeg",
        "description" => "Limited edition hoodie with luxury fabric."
    ]
];

// simple 404 check
if (!$product || !isset($products[$product])) {
    die("Product not found.");
}

$p = $products[$product]; // selected product

ob_start(); // start content
?>

<div class="product-wrapper">

    <div class="product-image">
        <img id="main-product-image"
             src="<?= $p['image'] ?>"
             alt="<?= $p['name'] ?>"
             class="zoomable">
    </div>

    <div class="product-info">
        <h1><?= $p['name'] ?></h1>
        <p class="product-price">£<?= $p['price'] ?></p>
        <p class="product-description"><?= $p['description'] ?></p>

        <label>Select Size:</label>
        <select class="size-select">
            <option>S</option>
            <option>M</option>
            <option>L</option>
            <option>XL</option>
        </select>

        <button class="add-cart-btn">Add to Cart</button>
    </div>
</div>

<!-- zoom modal -->
<div id="zoomModal" class="zoom-modal">
    <span class="zoom-close">&times;</span>
    <img class="zoom-modal-content" id="zoomImage">
</div>

<?php
$content = ob_get_clean(); // grab content
include "base.php"; // load layout
?>