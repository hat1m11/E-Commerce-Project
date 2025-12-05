<?php
session_start();
include "connection.php"; // connect to database

// Redirect user if they're not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=checkout.php");
    exit;
}

// Page details
$title = "Checkout - 6ixe7ven";
$extra_css = "<link rel='stylesheet' href='/E-Commerce-Project/static/css/checkout.css'>";

// Start capturing page content
ob_start();

$cart = $_SESSION['cart'] ?? [];

// If user confirms checkout, move them to order processing
if (isset($_POST['confirm'])) {
    header("Location: process_order.php");
    exit;
}
?>

<section class="checkout-section">
    <h1>Checkout</h1>

    <?php if (empty($cart)): ?>
        <!-- Cart empty message -->
        <p class='empty-msg'>Your cart is empty.</p>

    <?php else: 
        // Calculate total cost
        $total = 0;
        foreach ($cart as $item):
            $price = floatval($item['price']);
            $qty = intval($item['qty']);
            $subtotal = $price * $qty;
            $total += $subtotal;
    ?>
        <!-- Show each cart item -->
        <div class="checkout-item">
            <img src="/E-Commerce-Project/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
            <div class="item-info">
                <h3><?= htmlspecialchars($item['name']) ?></h3>
                <p>Price: £<?= number_format($price,2) ?></p>
                <p>Quantity: <?= $qty ?></p>
                <p>Subtotal: £<?= number_format($subtotal,2) ?></p>
            </div>
        </div>
    <?php endforeach; ?>

        <!-- Total price -->
        <div class="checkout-total">Total: £<?= number_format($total,2) ?></div>

        <!-- Confirm purchase button -->
        <div class="checkout-button">
            <form action="checkout.php" method="POST">
                <button type="submit" name="confirm" class="buy-now-btn">Buy Now</button>
            </form>
        </div>
    <?php endif; ?>
</section>

<?php
// Store captured output
$content = ob_get_clean();

// Load base layout template
include "base.php";
?>
