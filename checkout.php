<?php
// PAGE TITLE
$title = "Home - 6ixe7ven";

// OPTIONAL PAGE CSS (if needed)
$extra_css = '<link rel="stylesheet" href="static/css/index.css">';

// CAPTURE MAIN PAGE CONTENT
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

// LOAD BASE LAYOUT
include "base.php";
?>
