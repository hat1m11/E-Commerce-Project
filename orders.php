<?php
// PAGE TITLE
$title = "Home - 6ixe7ven";

// PAGE-SPECIFIC CSS (if any)
$extra_css = ''; 

// Capture page content
ob_start();
?>

<section class="hero">
    <h1>Welcome to 6ixe7ven</h1>
    <p>Discover our latest products and best deals!</p>
    <button class="shop-btn">Shop Now</button>
</section>

<?php
// End capturing content
$content = ob_get_clean();

// Load base layout
include "base.php";
?>
