<?php
// Set page title
$title = "Home - 6ixe7ven";

// Add CSS for this page
$extra_css = '<link rel="stylesheet" href="/static/css/index.css">';

// Begin capturing page content
ob_start();
?>

<section class="hero">
    <h1>Welcome to 6ixe7ven</h1>
    <p>Discover our latest products and best deals!</p>
    <button class="shop-btn">Shop Now</button>
</section>

<?php
// End capturing and store the result in $content
$content = ob_get_clean();

// Load the shared layout
include "base.php";
?>
