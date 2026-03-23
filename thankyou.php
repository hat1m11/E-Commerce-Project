<?php
session_start();
include "config.php";


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=checkout.php");
    exit;
}


if (empty($_SESSION['last_order_id'])) {
    header("Location: cart.php");
    exit;
}

$orderId = $_SESSION['last_order_id'];
unset($_SESSION['last_order_id']);

$title = "Thank You - 6ixe7ven";
$extra_css = "<link rel='stylesheet' href='css/checkout.css'>";

ob_start();
?>

<section class="thankyou-section">
    <h1>Thank you for your purchase!</h1>
    <p>Your order has been successfully placed.</p>
    <p><strong>Order ID:</strong> #<?= htmlspecialchars($orderId) ?></p>
    <p>We will process it shortly and notify you via email.</p>
    <a href="index.php" class="btn-back-home">Back to Home</a>
</section>

<?php
$content = ob_get_clean();
include "base.php";
?>
