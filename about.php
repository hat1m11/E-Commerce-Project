<?php
// PAGE TITLE
$title = "About Us - 6ixe7ven";

// PAGE-SPECIFIC CSS (optional for hero section)
$extra_css = '<link rel="stylesheet" href="static/css/about.css">';


// START CAPTURING PAGE CONTENT
ob_start();
?>

<section class="hero">
   <div class="about-left">
    <h4 class="about-subtitle">ABOUT US</h4>

    <h1 class="about-title">
        6ixe7ven<br>
        clothing <span class="highlight">exceptional</span><br>
        brand history.
</h1>

    <p class="about-text">
         We are the leading brand dedicated to delivering premium fashion and 
         unmatched customer experiences. Our products are designed for those 
         who value quality, confidence, and standout style.
    </p>
    
</div>

<div class="about-right">
    <div class="about-image">
        <img src="/E-Commerce-Project/static/images/about.jpeg">
</div>
</div>
</section>

<section class="reviews">
    <h2 class="reviews-heading">Customer Reviews</h2>
    <p class=" reviews-rating"> 5 star rating from 132 reviews</p>

    <div class="review-list">
        <!--Review box 1 -->
        <div class="review">
            <div class="review-header">
                <img src="/E-Commerce-Project/static/images/michael.jpeg"> 
                <div>
                    <h4>Michael</h4>
                    <span>1 month ago</span>
</div>
</div>
<p class="review-text"> Fast delivery and amazing products! </p>
<div class="review-footer">
    <div class = "stars">
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
</div>
</div>
</div>

<!--review 2 -->
<div class="review">
    <div class="review-header">
        <img src="/E-Commerce-Project/static/images/anne.jpeg"> 
        <div>
            <h4>Anne.J</h4>
            <span> 3 weeks ago </span>
</div>
</div>
<p class="review-text"> Really good quality </p>
<div class="review-footer">
    <div class = "stars">
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
</div>
</div>
</div>
<!--Review 3 -->
<div class="review">
    <div class="review-header">
        <img src="/E-Commerce-Project/static/images/pete.jpeg">
        <div>
            <h4>Peter Johnson</h4>
            <span>2 months ago</span>
</div>
</div>
<p class="review-text">Lovely customer service</p>
<div class="review-footer">
      <div class = "stars">
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
</div>
</div>
</div>
</div>
</section>
<?php
// END CAPTURE
$content = ob_get_clean();

// INCLUDE BASE TEMPLATE
include "base.php";
?>
