<?php
session_start();
include "connection.php"; // connect to the database

// Page title
$title = "Your Cart - 6ixe7ven";

// Page CSS + JS  (use an absolute-ish path so it always works)
$extra_css = "<link rel='stylesheet' href='/E-Commerce-Project/static/css/cart.css'>";
$extra_js  = "<script src='/E-Commerce-Project/static/js/cart_remove.js'></script>";

// Start capturing page content
ob_start();
?>

<section class="cart-section">
    <h1>Your Cart</h1>

    <?php
    // Get cart or default to empty array
    $cart = $_SESSION['cart'] ?? [];

    // Make sure every item has a valid qty
    foreach ($cart as &$citem) {
        if (!isset($citem['qty']) || intval($citem['qty']) < 1) {
            $citem['qty'] = 1;
        } else {
            $citem['qty'] = intval($citem['qty']);
        }
    }
    unset($citem); // clear reference

    // If cart empty, show message
    if (empty($cart)) {
        echo "<p class='empty-msg'>Your cart is empty.</p>";
    } else {
        // Loop through cart items
        foreach ($cart as $index => $item): ?>
            <div class="cart-item" data-price="<?= htmlspecialchars($item['price']) ?>">
                <img src="/E-Commerce-Project/<?= htmlspecialchars($item['image']) ?>"
                     alt="<?= htmlspecialchars($item['name']) ?>"
                     width="80">

                <div class="item-info">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <p>£<?= htmlspecialchars(number_format($item['price'], 2)) ?></p>

                    <div class="qty-control">
                        <button class="qty-btn minus" data-index="<?= $index ?>">−</button>
                        <span class="qty-number"><?= $item['qty'] ?></span>
                        <button class="qty-btn plus" data-index="<?= $index ?>">+</button>
                    </div>
                </div>

                <button class="remove-item" data-index="<?= $index ?>">Remove</button>
            </div>
            <hr>
        <?php endforeach;
    }
    ?>

    <?php
    // Calculate cart total
    $total = 0.00;
    if (!empty($cart)) {
        foreach ($cart as $it) {
            $total += floatval($it['price']) * intval($it['qty']);
        }
    }
    ?>

    <?php if (!empty($cart)): ?>
        <!-- Show total and checkout button -->
        <div class="cart-total">
            Total: <span class="total-price">£<?= number_format($total, 2) ?></span>
        </div>

        <div class="checkout-button-container">
            <!-- Use <a> instead of <button> to dodge browser button default styling -->
            <a href="checkout.php" class="buy-now-btn">Buy Now</a>
        </div>
    <?php endif; ?>
</section>

<?php
// Finish capturing content
$content = ob_get_clean();

// Load base layout
include "base.php";
?>
