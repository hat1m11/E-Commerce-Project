<?php
session_start();
include "config.php";

// redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=checkout.php");
    exit;
}

// empty cart after checkout
unset($_SESSION['cart']);

$title = "Thank You - 6ixe7ven"; // page title
$extra_css = "<link rel='stylesheet' href='static/css/checkout.css'>"; // page css

ob_start(); // start page content
?>

<section class="thankyou-section">
    <h1>Thank you for your purchase!</h1>
    <p>Your order has been successfully placed.</p>
    <p>We will process it shortly and notify you via email.</p>
    <a href="index.php" class="btn-back-home">Back to Home</a>
</section>

<?php
$content = ob_get_clean(); // get page content
include "base.php"; // load layout
?>
