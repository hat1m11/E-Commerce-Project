<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// PAGE TITLE
$title = "Home - 6ixe7ven";

// PAGE-SPECIFIC CSS
$extra_css = '<link rel="stylesheet" href="static/css/index.css">';


// PAGE-SPECIFIC JS
$extra_js = '<script src="static/js/bannerSlide.js"></script>';

// START CAPTURING PAGE CONTENT
ob_start();
?>

<!-- Banner section -->
<section class="banner">
    <div class="rotation">
        <img src="static/images/banner/banner1.png" class="rotation-image active" alt="Banner 1">
        <img src="static/images/banner/banner2.jpg" class="rotation-image" alt="Banner 2">
        <img src="static/images/banner/banner3.jpg" class="rotation-image" alt="Banner 3">
    </div>
</section>

<div class="pagination">
    <button class="page active">1</button>
    <button class="page">2</button>
    <button class="page">3</button>
    <button class="page">4</button>
    <button class="page">5</button>
</div>

<?php
// END CAPTURE AND STORE CONTENT
$content = ob_get_clean();

// LOAD BASE LAYOUT
include "base.php";
?>
