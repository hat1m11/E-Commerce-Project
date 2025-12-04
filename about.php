<?php
// Page title
$title = "Home - 6ixe7ven";

// Extra CSS for this page
$extra_css = '<link rel="stylesheet" href="static/css/index.css">';

// Start capturing page content
ob_start();
?>

<section class="hero">
    <h1>Welcome to 6ixe7ven</h1>
    <p>Discover our latest products and best deals!</p>
    <button class="shop-btn">Shop Now</button>
</section>

<?php
// Grab the buffered content
$content = ob_get_clean();

// Load the base template
include "base.php";
?>
