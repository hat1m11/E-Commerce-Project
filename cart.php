<?php
session_start();
include "config.php";

// PAGE TITLE
$title = "Your Cart - 6ixe7ven";

// PAGE CSS + JS
$extra_css = "<link rel='stylesheet' href='$BASE_URL/static/css/cart.css'>";
$extra_js  = "<script src='$BASE_URL/static/js/cart_remove.js'></script>";

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

        <div class="cart-item" data-price="<?= $item['price'] ?>">

            <img src="<?= $item['image'] ?>"
                 alt="<?= htmlspecialchars($item['name']) ?>"
                 width="80">

            <div class="item-info">
                <h3><?= htmlspecialchars($item['name']) ?></h3>
                <p>£<?= htmlspecialchars($item['price']) ?></p>

                <div class="qty-control">
                    <button class="qty-btn minus" data-index="<?= $index ?>">−</button>
                    <span class="qty-number"><?= $item['qty'] ?? 1 ?></span>
                    <button class="qty-btn plus" data-index="<?= $index ?>">+</button>
                </div>
            </div>

            <button class="remove-item" data-index="<?= $index ?>">Remove</button>
        </div>

        <hr>

        <?php endforeach;
    }
    ?>
</section>

<div class="cart-total">
    Total: <span class="total-price">£0.00</span>
</div>

<?php
$content = ob_get_clean();
include "base.php";
?>
