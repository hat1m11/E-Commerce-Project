<?php
session_start();
include "config.php";

// PAGE TITLE
$title = "Your Cart - 6ixe7ven";

// PAGE CSS + JS
$extra_css = "<link rel='stylesheet' href='$BASE_URL/static/css/cart.css'>";
$extra_js  = "<script src='$BASE_URL/static/js/cart.js'></script>";

// Start capturing content
ob_start();
?>

<section class="cart-section">
    <h1>Your Cart</h1>

    <?php
    $cart = $_SESSION['cart'] ?? [];

    if (empty($cart)) {
        echo "<p class='empty-msg'>Your cart is empty.</p>";
    } else {
        foreach ($cart as $index => $item): ?>
        
        <div class="cart-item">
            <img src="<?= $item['image'] ?>" alt="<?= htmlspecialchars($item['name']) ?>">

            <div class="item-info">
                <h3><?= htmlspecialchars($item['name']) ?></h3>
                <p class="price">£<?= htmlspecialchars($item['price']) ?></p>
            </div>

            <button class="remove-btn" data-index="<?= $index ?>">Remove</button>
        </div>

        <hr>

        <?php endforeach;
    }
    ?>
</section>

<?php
$content = ob_get_clean();
include "base.php";
?>
