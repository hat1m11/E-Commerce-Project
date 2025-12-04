<?php
session_start(); 
include "connection.php"; 

$title = "Home - 6ixe7ven"; 
$extra_css = '<link rel="stylesheet" href="css/index.css">'; 
$extra_js = <<<EOT
<script src="js/bannerSlide.js"></script>
<script src="js/cart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var imgs = document.querySelectorAll(".product-card img");
    imgs.forEach(function(img) {
        img.addEventListener("click", function() {
            var zoomImage = document.getElementById("zoomImage");
            var zoomModal = document.getElementById("zoomModal");
            if (zoomImage && zoomModal) {
                zoomImage.src = img.src;
                zoomModal.style.display = "flex";
            }
        });
    });

    var zoomClose = document.getElementById("zoomClose");
    if (zoomClose) {
        zoomClose.addEventListener("click", function() {
            var zoomModal = document.getElementById("zoomModal");
            if (zoomModal) zoomModal.style.display = "none";
        });
    }

    var zoomModalElem = document.getElementById("zoomModal");
    if (zoomModalElem) {
        zoomModalElem.addEventListener("click", function(e) {
            if (e.target && e.target.id === "zoomModal") {
                zoomModalElem.style.display = "none";
            }
        });
    }
});
</script>
EOT;

ob_start();
?>

<section class="banner">
    <div class="rotation">
        <img src="images/banner/banner1.png" class="rotation-image active">
        <img src="images/banner/banner2.jpg" class="rotation-image">
        <img src="images/banner/banner3.jpg" class="rotation-image">

        <button class="banner-arrow banner-prev">&#8249;</button>
        <button class="banner-arrow banner-next">&#8250;</button>

        <div class="banner-indicators">
            <span class="banner-indicator active"></span>
            <span class="banner-indicator"></span>
            <span class="banner-indicator"></span>
        </div>
    </div>
</section>

<section class="product-section">
    <h2 class="section-title">Featured Hoodies</h2>

    <div class="product-grid">
        <div class="product-card">
            <img src="images/hoodie1.jpeg" alt="6ixe7ven Hoodie 1">
            <h3>6ixe7ven Hoodie 1</h3>
            <p class="price">£39.99</p>
            <button class="add-btn" data-id="1" data-name="6ixe7ven Hoodie 1" data-price="39.99" data-image="images/hoodie1.jpeg">Add to Cart</button>
        </div>

        <div class="product-card">
            <img src="images/hoodie2.jpeg" alt="6ixe7ven Hoodie 2">
            <h3>6ixe7ven Hoodie 2</h3>
            <p class="price">£39.99</p>
            <button class="add-btn" data-id="2" data-name="6ixe7ven Hoodie 2" data-price="39.99" data-image="images/hoodie2.jpeg">Add to Cart</button>
        </div>

        <div class="product-card">
            <img src="images/hoodie3.jpeg" alt="6ixe7ven Hoodie 3">
            <h3>6ixe7ven Hoodie 3</h3>
            <p class="price">£49.99</p>
            <button class="add-btn" data-id="3" data-name="6ixe7ven Hoodie 3" data-price="49.99" data-image="images/hoodie3.jpeg">Add to Cart</button>
        </div>
    </div>
</section>

<div id="zoomModal">
    <span id="zoomClose">&times;</span>
    <img id="zoomImage" src="" alt="Zoomed product">
</div>

<?php
$content = ob_get_clean();
include "base.php";
?>
