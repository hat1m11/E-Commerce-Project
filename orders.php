<?php
$title = "Home - 6ixe7ven"; // page title
$extra_css = ''; // page css

ob_start(); // start content
?>

<section class="hero">
    <h1>Welcome to 6ixe7ven</h1>
    <p>Discover our latest products and best deals!</p>
    <button class="shop-btn">Shop Now</button>
</section>

<?php
$content = ob_get_clean(); // get content
include "base.php"; // load layout
?>