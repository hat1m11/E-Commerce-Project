<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "config.php";
require_once "connection.php";

if (!isset($_GET['id'])) {
    die("Product not found.");
}

$id = (int)$_GET['id'];

$allProducts = [
    4   => ["name" => "Men's Hoodie 1",    "price" => 39.99, "image" => "hoodie1.jpeg",    "description" => "Premium cotton hoodie with a soft interior lining."],
    5   => ["name" => "Men's Tracksuit",   "price" => 59.99, "image" => "mtracksuit1.jpeg","description" => "Comfortable tapered-fit tracksuit set."],
    6   => ["name" => "Men's T-shirt 1",   "price" => 24.99, "image" => "mtshirt1.jpeg",   "description" => "High-quality cotton T-shirt with a relaxed fit."],
    7   => ["name" => "Men's Hoodie 2",    "price" => 49.99, "image" => "hoodie2.jpeg",    "description" => "Fleece-lined hoodie designed for warmth."],
    8   => ["name" => "Men's T-shirt 2",   "price" => 22.99, "image" => "mtshirt2.jpeg",   "description" => "Lightweight graphic T-shirt."],
    201 => ["name" => "Women's Hoodie 1",  "price" => 39.99, "image" => "whoodie1.jpeg",   "description" => "Soft fleece hoodie with a relaxed fit."],
    202 => ["name" => "Women's Jeans",     "price" => 49.99, "image" => "wjeans1.jpeg",    "description" => "Wide-leg light blue denim, perfect everyday jeans."],
    203 => ["name" => "Women's T-shirt 1", "price" => 19.99, "image" => "wtshirt1.jpeg",   "description" => "Classic cotton tee with a smooth feel."],
    204 => ["name" => "Women's Hoodie 2",  "price" => 44.99, "image" => "whoodie2.jpeg",   "description" => "Oversized hoodie with premium brushed interior."],
    205 => ["name" => "Women's T-shirt 2", "price" => 19.99, "image" => "wtshirt2.jpeg",   "description" => "Light grey tee, soft and breathable."],
    401 => ["name" => "Signature Cap",     "price" => 18.99, "image" => "cap1.jpeg",       "description" => "Classic streetwear cap with adjustable fit."],
    402 => ["name" => "Everyday Beanie",   "price" => 16.99, "image" => "beanie1.jpeg",    "description" => "Warm knit beanie for everyday wear."],
    403 => ["name" => "Crossbody Bag",     "price" => 29.99, "image" => "bag1.jpeg",       "description" => "Compact crossbody bag with multiple compartments."],
    404 => ["name" => "Crew Socks Pack",   "price" => 12.99, "image" => "socks1.jpeg",     "description" => "Comfortable everyday socks pack."],
    405 => ["name" => "Utility Belt",      "price" => 14.99, "image" => "belt1.jpeg",      "description" => "Durable utility belt with adjustable buckle."],
	301 => ["name" => "Kids Hoodie",    "price" => 29.99, "image" => "khoodie1.jpeg",    "description" => "Soft kids hoodie designed for everyday comfort and warmth."],
	302 => ["name" => "Kids Tracksuit", "price" => 44.99, "image" => "ktracksuit1.jpeg", "description" => "Comfortable kids tracksuit made for active days and casual style."],
	303 => ["name" => "Kids T-shirt",   "price" => 16.99, "image" => "ktshirt1.jpeg",    "description" => "Breathable kids tee, lightweight and easy to wear all day."],
	304 => ["name" => "Kids Jacket",    "price" => 49.99, "image" => "kjacket1.jpeg",    "description" => "Stylish kids jacket with a clean streetwear look and practical comfort."],
	305 => ["name" => "Kids Joggers",   "price" => 24.99, "image" => "kjoggers1.jpeg",   "description" => "Relaxed-fit kids joggers made for movement and everyday wear."],
    501 => ["name" => "Street Trainers",    "price" => 64.99, "image" => "trainers1.jpeg", "description" => "Modern street trainers built for comfort and everyday wear."],
    502 => ["name" => "High-Top Sneakers",  "price" => 69.99, "image" => "sneakers1.jpeg", "description" => "High-top sneakers with a bold streetwear design and premium feel."],
    503 => ["name" => "Everyday Slides",    "price" => 24.99, "image" => "slides1.jpeg",   "description" => "Lightweight slides perfect for casual comfort and daily use."],
    504 => ["name" => "Runner Trainers",    "price" => 59.99, "image" => "runners1.jpeg",  "description" => "Performance-inspired runners combining style and functionality."],
    505 => ["name" => "Urban Boots",     "price" => 79.99, "image" => "boots1.jpeg",    "description" => "Durable urban boots designed for both style and long-lasting wear."],
];

if (!isset($allProducts[$id])) {
    die("Product not found.");
}

$product = $allProducts[$id];
$title   = $product['name'];
$isKids = ($id >= 301 && $id <= 305);

$stock    = null;
$inStock  = true;
$stmt = $conn->prepare("SELECT stock FROM products WHERE product_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($stockVal);
if ($stmt->fetch()) {
    $stock   = (int)$stockVal;
    $inStock = $stock > 0;
}
$stmt->close();

$extra_css = '<link rel="stylesheet" href="' . $BASE_URL . '/css/single_product.css">';
$extra_js  = '<script src="' . $BASE_URL . '/js/cart.js"></script>';

function starsText(int $rating): string {
    $rating = max(0, min(5, $rating));
    return str_repeat("⭐", $rating) . str_repeat("☆", 5 - $rating);
}


$avgRating = 0.0;
$reviewCount = 0;
$stmt = $conn->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total FROM reviews WHERE product_id = ? AND status = 'approved'");
$stmt->bind_param("i", $id);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();
$stmt->close();
if ($stats) {
    $avgRating   = (float)($stats["avg_rating"] ?? 0);
    $reviewCount = (int)($stats["total"] ?? 0);
}

$reviews = [];
$stmt = $conn->prepare("SELECT r.rating, r.comment, r.created_at, u.username FROM reviews r LEFT JOIN users u ON u.user_id = r.user_id WHERE r.product_id = ? AND r.status = 'approved' ORDER BY r.created_at DESC");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) { $reviews[] = $row; }
$stmt->close();

ob_start();
?>

<section class="product-page">

    <div class="product-left">
        <div class="product-img-wrap">
            <img src="<?= $BASE_URL ?>/images/<?= htmlspecialchars($product['image']) ?>"
                 class="product-image <?= !$inStock ? 'oos-img' : '' ?>"
                 alt="<?= htmlspecialchars($product['name']) ?>">
            <?php if (!$inStock): ?>
                <div class="oos-overlay"><span>Out of Stock</span></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="product-right">

        <h1><?= htmlspecialchars($product['name']) ?></h1>

        <?php if (!$inStock): ?>
            <div class="oos-banner">Out of Stock</div>
        <?php elseif ($stock !== null && $stock <= 5): ?>
            <div class="low-stock-banner">Only <?= $stock ?> left — order soon!</div>
        <?php endif; ?>

        <p class="price">£<?= number_format($product['price'], 2) ?></p>
        <p class="description"><?= htmlspecialchars($product['description']) ?></p>

        <p style="margin:10px 0; color:#555;">
            ⭐ <?= number_format($avgRating, 1) ?> / 5
            (<?= (int)$reviewCount ?> review<?= $reviewCount === 1 ? "" : "s" ?>)
        </p>

        <form id="productForm">

            <label for="size">Size:</label>
			<select id="size" name="size" <?= !$inStock ? 'disabled' : '' ?>>
   					 <?php if ($isKids): ?>
        	<option value="3-4 Y">3-4 Y</option>
        	<option value="5-6 Y">5-6 Y</option>
        	<option value="7-8 Y">7-8 Y</option>
       		<option value="9-10 Y">9-10 Y</option>
    				<?php else: ?>
        	<option value="S">Small (S)</option>
        	<option value="M">Medium (M)</option>
        	<option value="L">Large (L)</option>
    	<?php endif; ?>
	</select>

            <label for="qty">Quantity:</label>
            <input type="number" id="qty" name="qty" value="1" min="1"
                   <?= !$inStock ? 'disabled' : '' ?>>

            <?php if ($inStock): ?>
                <button type="button"
                        id="addToCartBtn"
                        class="add-btn"
                        data-id="<?= $id ?>"
                        data-name="<?= htmlspecialchars($product['name']) ?>"
                        data-price="<?= $product['price'] ?>"
                        data-image="<?= $BASE_URL ?>/images/<?= htmlspecialchars($product['image']) ?>">
                    Add to Cart
                </button>
            <?php else: ?>
                <button type="button" class="add-btn oos-btn" disabled>
                    Out of Stock
                </button>
            <?php endif; ?>

        </form>

    </div>

</section>


<section style="padding:0 30px 30px; max-width:900px; margin:0 auto;">

    <h2 style="margin-top:0;">Reviews</h2>

    <?php if (isset($_GET["review"])): ?>
        <?php
            $msg = "";
            switch ($_GET["review"]) {
                case "ok":       $msg = "Thanks! Your review has been saved."; break;
                case "notfound": $msg = "Product not found."; break;
                default:         $msg = "Could not save your review. Please try again."; break;
            }
        ?>
        <div style="background:#f2f2f2; padding:10px; border-radius:10px; margin:12px 0;">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <?php if (!isset($_SESSION["user_id"])): ?>
        <p><a href="<?= $BASE_URL ?>/login.php">Log in</a> to leave a review.</p>
    <?php else: ?>
        <form method="POST" action="<?= $BASE_URL ?>/reviewSubmit.php" style="display:grid; gap:10px; max-width:520px; margin:14px 0;">
            <input type="hidden" name="product_id" value="<?= (int)$id ?>">
            <input type="hidden" name="redirect"    value="<?= htmlspecialchars($_SERVER["REQUEST_URI"]) ?>">
            <label>
                Rating
                <select name="rating" required style="padding:10px; width:100%;">
                    <option value="">Select…</option>
                    <option value="5">5 - Excellent</option>
                    <option value="4">4 - Good</option>
                    <option value="3">3 - Okay</option>
                    <option value="2">2 - Poor</option>
                    <option value="1">1 - Bad</option>
                </select>
            </label>
            <label>
                Comment (optional)
                <textarea name="comment" maxlength="2000" style="padding:10px; width:100%; min-height:110px;"></textarea>
            </label>
            <button type="submit" style="padding:10px 14px; cursor:pointer;">Submit review</button>
        </form>
    <?php endif; ?>

    <div style="display:grid; gap:10px; margin-top:14px;">
        <?php if (!$reviews): ?>
            <p style="color:#666;">No reviews yet.</p>
        <?php else: ?>
            <?php foreach ($reviews as $r): ?>
                <div style="background:#fff; border:1px solid #eee; border-radius:12px; padding:12px;">
                    <div style="display:flex; justify-content:space-between; gap:12px;">
                        <strong><?= htmlspecialchars($r["username"] ?? "User") ?></strong>
                        <span><?= htmlspecialchars(starsText((int)$r["rating"])) ?></span>
                    </div>
                    <?php if (!empty($r["comment"])): ?>
                        <div style="margin-top:8px; white-space:pre-wrap; color:#333;">
                            <?= htmlspecialchars($r["comment"]) ?>
                        </div>
                    <?php endif; ?>
                    <small style="color:#777; display:block; margin-top:8px;">
                        <?= htmlspecialchars($r["created_at"]) ?>
                    </small>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</section>

<?php if ($inStock): ?>
<script>
document.getElementById("addToCartBtn").addEventListener("click", () => {
    const btn = document.getElementById("addToCartBtn");
    btn.dataset.size = document.getElementById("size").value;
    btn.dataset.qty  = document.getElementById("qty").value;
});
</script>
<?php endif; ?>

<?php
$content = ob_get_clean();
include "base.php";
?>