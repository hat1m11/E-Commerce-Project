<?php
$title = "Hoodie - Product Detail";
$extra_css = '<link rel="stylesheet" href="static/css/products.css">';

ob_start();
?>

<section class="product-details">
  <div class="product-container">
    <div class="product-image">
      <img src="/E-Commerce-Project/static/images/black_hoodie.jpeg" alt="black-hoodie">
    </div>

    <div class="product-info">
      <h1 class="title">Hoodie</h1>
      <p class="color-product">Black</p>

      <div class="product-rating">
        <span class="stars">
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
        </span>
        <span class="review-count">(12 reviews)</span>
      </div>

      <div class="product-price">
        <span class="price"> 29.99</span>
        <div class="quantity">
          <label for="amount">Qty:</label>
          <input type="number" id="amount" value="2" min="1">
        </div>
        <div class="total-price">Total: 59.98</div>
      </div>

      <button class="add-to-cart">Add to Cart</button>

      <div class="product-description">
        <h3>Description</h3>
        <ul>
          <li>100% pure cotton </li>
          <li>Colour: White</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<script>
document.getElementById('amount').addEventListener('input', function () {
  const unitPrice = 29.99;
  const amount = parseInt(this.value) || 1;
  const total = unitPrice * amount;
  document.querySelector('.total-price').textContent = `Total: $${total.toFixed(2)}`;
});
</script>

<?php
$content = ob_get_clean();
include "base.php";
?>
