<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "connection.php";
include_once "config.php";

$title     = "Accessories - 6ixe7ven";
$extra_css = '<link rel="stylesheet" href="css/accessories.css">';
$extra_js  = '<script src="js/cart.js"></script>
<script src="js/accessories.js"></script>';

$products = [
    ["id" => 401, "name" => "Signature Cap",   "price" => 18.99, "image" => "cap1.jpeg",    "type" => "Cap",    "badge" => "New In"],
    ["id" => 402, "name" => "Everyday Beanie", "price" => 16.99, "image" => "beanie1.jpeg", "type" => "Beanie", "badge" => ""],
    ["id" => 403, "name" => "Crossbody Bag",   "price" => 29.99, "image" => "bag1.jpeg",    "type" => "Bag",    "badge" => "Popular"],
    ["id" => 404, "name" => "Crew Socks Pack", "price" => 12.99, "image" => "socks1.jpeg",  "type" => "Socks",  "badge" => ""],
    ["id" => 405, "name" => "Utility Belt",    "price" => 14.99, "image" => "belt1.jpeg",   "type" => "Belt",   "badge" => ""],
];

// ── Fetch stock for all accessory IDs ────────────────────────
$ids          = array_column($products, 'id');
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stockMap     = [];
$types        = str_repeat('i', count($ids));
$stmt         = $conn->prepare("SELECT product_id, stock FROM products WHERE product_id IN ($placeholders)");
$stmt->bind_param($types, ...$ids);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $stockMap[(int)$row['product_id']] = (int)$row['stock'];
}
$stmt->close();

ob_start();
?>

<!-- ================= HERO ================= -->
<section class="ac-hero">
    <div class="ac-hero-inner">
        <span class="ac-eyebrow">6ixe7ven Collection</span>
        <h1>Accessories</h1>
        <p class="ac-hero-sub">Complete the look with premium accessories built for everyday streetwear styling.</p>
    </div>
</section>

<!-- ================= PRODUCTS ================= -->
<section class="ac-section">

    <div class="ac-controls">
        <div class="ac-control-box">
            <label for="typeFilter">Filter by Type</label>
            <select id="typeFilter" class="ac-control-select">
                <option value="All">All</option>
                <option value="Cap">Cap</option>
                <option value="Beanie">Beanie</option>
                <option value="Bag">Bag</option>
                <option value="Socks">Socks</option>
                <option value="Belt">Belt</option>
            </select>
        </div>
        <div class="ac-control-box">
            <label for="sortSelect">Sort by</label>
            <select id="sortSelect" class="ac-control-select">
                <option value="">Default</option>
                <option value="newest">Newest</option>
                <option value="priceLow">Price: Low → High</option>
                <option value="priceHigh">Price: High → Low</option>
            </select>
        </div>
    </div>

    <div class="ac-grid" id="ac-grid">
        <?php foreach ($products as $p):
            $pid     = $p['id'];
            $stock   = $stockMap[$pid] ?? null;
            $inStock = ($stock === null || $stock > 0);
        ?>
        <div class="ac-card <?= !$inStock ? 'is-oos' : '' ?>" data-type="<?= htmlspecialchars($p['type']) ?>">

            <div class="ac-card-img">
                <?php if (!$inStock): ?>
                    <div class="oos-overlay"><span>Out of Stock</span></div>
                <?php else: ?>
                    <?php if ($p['badge']): ?>
                        <span class="ac-badge"><?= htmlspecialchars($p['badge']) ?></span>
                    <?php endif; ?>
                    <?php if ($stock !== null && $stock <= 5): ?>
                        <div class="low-stock-tag">Only <?= $stock ?> left</div>
                    <?php endif; ?>
                <?php endif; ?>
                <span class="ac-type-tag"><?= htmlspecialchars($p['type']) ?></span>
                <a href="single_product.php?id=<?= $pid ?>">
                    <img src="images/<?= htmlspecialchars($p['image']) ?>"
                         alt="<?= htmlspecialchars($p['name']) ?>"
                         class="<?= !$inStock ? 'oos-img' : '' ?>"
                         onerror="this.onerror=null;this.src='images/6ixe7venLogo.png';">
                </a>
            </div>

            <div class="ac-card-body">
                <a href="single_product.php?id=<?= $pid ?>" class="ac-card-name">
                    <?= htmlspecialchars($p['name']) ?>
                </a>
                <p class="ac-card-price">&pound;<?= number_format($p['price'], 2) ?></p>

                <?php if ($inStock): ?>
                    <button class="ac-add-btn add-btn"
                        data-id="<?= $pid ?>"
                        data-name="<?= htmlspecialchars($p['name']) ?>"
                        data-price="<?= $p['price'] ?>"
                        data-image="images/<?= htmlspecialchars($p['image']) ?>">
                        Add to Cart
                    </button>
                <?php else: ?>
                    <button class="ac-add-btn oos-btn" disabled>Out of Stock</button>
                <?php endif; ?>
            </div>

        </div>
        <?php endforeach; ?>
    </div>

</section>

<?php
$content = ob_get_clean();
include "base.php";
?>