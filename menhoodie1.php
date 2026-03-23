<?php
include_once "config.php";

// Check if ID exists
if (!isset($_GET['id'])) {
    die("Product not found.");
}

$id = intval($_GET['id']);

// PRODUCT LIST — both men & women
$allProducts = [
    // MEN
    4 => ["name" => "Men's Hoodie 1", "price" => 39.99, "image" => "hoodie1.jpeg", "desc" => "Comfortable premium men's hoodie."],
    5 => ["name" => "Men's Tracksuit", "price" => 59.99, "image" => "mtracksuit1.jpeg", "desc" => "Complete tracksuit set with a sporty fit."],
    6 => ["name" => "Men's T-shirt 1", "price" => 24.99, "image" => "mtshirt1.jpeg", "desc" => "Cotton T-shirt designed for daily wear."],
    7 => ["name" => "Men's Hoodie 2", "price" => 44.99, "image" => "hoodie2.jpeg", "desc" => "Soft fleece hoodie for warmth."],
    8 => ["name" => "Men's T-shirt 2", "price" => 22.99, "image" => "mtshirt2.jpeg", "desc" => "Breathable basic T-shirt."],

    // WOMEN
    101 => ["name" => "Women's Hoodie 1", "price" => 39.99, "image" => "whoodie1.jpeg", "desc" => "Premium cotton hoodie for women."],
    102 => ["name" => "Women's Leggings", "price" => 29.99, "image" => "wleggings1.jpeg", "desc" => "High-stretch leggings for comfort."],
    103 => ["name" => "Women's T-shirt 1", "price" => 19.99, "image" => "wtshirt1.jpeg", "desc" => "Soft everyday women's T-shirt."],
    104 => ["name" => "Women's Tracksuit", "price" => 54.99, "image" => "wtracksuit1.jpeg", "desc" => "Stylish tracksuit set for any activity."],
    105 => ["name" => "Women's Hoodie 2", "price" => 44.99, "image" => "whoodie2.jpeg", "desc" => "Warm fleece hoodie for women."],
];

// Check if product exists
if (!isset($allProducts[$id])) {
    die("Invalid product ID.");
}

$product = $allProducts[$id];

// Page-specific CSS & JS
$title = $product["name"];
$extra_css = '<link rel="stylesheet" href="' . $BASE_URL . '/css/product_detail.css">';
$extra_js = '<script src="' . $BASE_URL . '/js/cart.js"></script>';

ob_start();
?>

<section class="product-detail">

    <div class="image-section">
        <img src="<?= $BASE_URL ?>/images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
    </div>

    <div class="info-section">
        <h1><?= $product['name'] ?></h1>

        <p class="price">£<?= number_format($product['price'], 2) ?></p>

        <p class="description"><?= $product['desc'] ?></p>

        <button class="add-btn"
                data-id="<?= $id ?>"
                data-name="<?= $product['name'] ?>"
                data-price="<?= $product['price'] ?>"
                data-image="<?= $BASE_URL ?>/images/<?= $product['image'] ?>">
            Add to Cart
        </button>
    </div>

</section>

<?php
$content = ob_get_clean();
include "base.php";
?>
