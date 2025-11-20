<?php
// PAGE TITLE
$title = "Home - 6ixe7ven";

// PAGE-SPECIFIC CSS (optional for hero section)
$extra_css = '<link rel="stylesheet" href="/static/css/index.css">';

// START CAPTURING PAGE CONTENT
ob_start();
?>

<section class="hero">
    <h1>Welcome to 6ixe7ven</h1>
    <p>Discover our latest products and best deals!</p>
    <button class="shop-btn">Shop Now</button>
</section>

<?php
// END CAPTURE
$content = ob_get_clean();

// INCLUDE BASE TEMPLATE
include "base.php";
?>
