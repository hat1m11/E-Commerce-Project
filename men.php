<?php
include_once "config.php";

$title     = "Men's Collection - 6ixe7ven";
$extra_css = '
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="' . $BASE_URL . '/css/men.css">
';

$extra_js = '
<script>window.BASE_URL = ' . json_encode($BASE_URL ?? '') . ';</script>
<script src="' . $BASE_URL . '/js/cart.js"></script>
<script src="' . $BASE_URL . '/js/men.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {

    const cards      = document.querySelectorAll(".mn-card");
    const typeFilter = document.getElementById("typeFilter");
    const sortSelect = document.getElementById("sortSelect");
    const grid       = document.querySelector(".mn-grid");
    const countEl    = document.getElementById("mn-count");

    function getPrice(card) {
        return parseFloat(card.dataset.price);
    }

    function applyFiltersAndSort() {
        const type = typeFilter.value;
        const sort = sortSelect.value;

        let visible = Array.from(cards).filter(card => {
            return type === "All" || card.dataset.type === type;
        });

        if (sort === "priceLow")  visible.sort((a, b) => getPrice(a) - getPrice(b));
        if (sort === "priceHigh") visible.sort((a, b) => getPrice(b) - getPrice(a));
        if (sort === "newest")    visible.reverse();

        cards.forEach(c => c.style.display = "none");
        visible.forEach(c => {
            c.style.display = "";
            grid.appendChild(c);
        });

        if (countEl) countEl.textContent = visible.length + " product" + (visible.length !== 1 ? "s" : "");
    }

    typeFilter?.addEventListener("change", applyFiltersAndSort);
    sortSelect?.addEventListener("change", applyFiltersAndSort);

    /* ── Image zoom ── */
    const zoomModal = document.getElementById("mnZoomModal");
    const zoomImage = document.getElementById("mnZoomImage");
    const zoomClose = document.getElementById("mnZoomClose");

    document.querySelectorAll(".mn-card-img img").forEach(img => {
        img.addEventListener("click", () => {
            zoomImage.src = img.src;
            zoomModal.classList.add("open");
        });
    });

    zoomClose?.addEventListener("click",  () => zoomModal.classList.remove("open"));
    zoomModal?.addEventListener("click", e => { if (e.target === zoomModal) zoomModal.classList.remove("open"); });

});
</script>
';

$products = [
    ["id" => 4, "name" => "Men's Hoodie 1",  "price" => 39.99, "image" => "hoodie1.jpeg",     "type" => "Hoodie",    "badge" => "New In"],
    ["id" => 5, "name" => "Men's Tracksuit",  "price" => 59.99, "image" => "mtracksuit1.jpeg", "type" => "Tracksuit", "badge" => "Bestseller"],
    ["id" => 6, "name" => "Men's T-shirt 1",  "price" => 24.99, "image" => "mtshirt1.jpeg",    "type" => "T-shirt",   "badge" => ""],
    ["id" => 7, "name" => "Men's Hoodie 2",   "price" => 44.99, "image" => "hoodie2.jpeg",     "type" => "Hoodie",    "badge" => "Limited"],
    ["id" => 8, "name" => "Men's T-shirt 2",  "price" => 22.99, "image" => "mtshirt2.jpeg",    "type" => "T-shirt",   "badge" => ""],
];

ob_start();
?>

<!-- ================= PAGE HEADING ================= -->
<section class="mn-heading">
    <div class="mn-heading-inner">

        <div class="mn-breadcrumb">
            <a href="<?= $BASE_URL ?>/index.php">Home</a>
            <span>&rsaquo;</span>
            <span>Men</span>
        </div>

        <div class="mn-heading-row">
            <h1 class="mn-title">Men's Collection</h1>
            <span id="mn-count" class="mn-count"><?= count($products) ?> products</span>
        </div>

        <div class="mn-controls">

            <div class="mn-control-group">
                <label for="typeFilter">Category</label>
                <select id="typeFilter" class="mn-select">
                    <option value="All">All</option>
                    <option value="Hoodie">Hoodies</option>
                    <option value="T-shirt">T-shirts</option>
                    <option value="Tracksuit">Tracksuits</option>
                </select>
            </div>

            <div class="mn-control-group">
                <label for="sortSelect">Sort by</label>
                <select id="sortSelect" class="mn-select">
                    <option value="">Default</option>
                    <option value="newest">Newest</option>
                    <option value="priceLow">Price: Low &rarr; High</option>
                    <option value="priceHigh">Price: High &rarr; Low</option>
                </select>
            </div>

        </div>
    </div>
</section>


<!-- ================= PRODUCTS GRID ================= -->
<section class="mn-grid-section">
    <div class="mn-grid" id="mn-grid">

        <?php foreach ($products as $p): ?>
        <div class="mn-card"
             data-type="<?= htmlspecialchars($p['type']) ?>"
             data-price="<?= $p['price'] ?>">

            <div class="mn-card-img">
                <?php if (!empty($p['badge'])): ?>
                    <span class="mn-badge"><?= htmlspecialchars($p['badge']) ?></span>
                <?php endif; ?>
                <a href="<?= $BASE_URL ?>/single_product.php?id=<?= $p['id'] ?>">
                    <img src="<?= $BASE_URL ?>/images/<?= $p['image'] ?>"
                         alt="<?= htmlspecialchars($p['name']) ?>"
                         onerror="this.onerror=null;this.src='<?= $BASE_URL ?>/images/6ixe7venLogo.png';">
                </a>
            </div>

            <div class="mn-card-body">
                <span class="mn-card-type"><?= htmlspecialchars($p['type']) ?></span>
                <h3 class="mn-card-name">
                    <a href="<?= $BASE_URL ?>/single_product.php?id=<?= $p['id'] ?>">
                        <?= htmlspecialchars($p['name']) ?>
                    </a>
                </h3>
                <p class="mn-card-price">&pound;<?= number_format($p['price'], 2) ?></p>
                <button class="add-btn"
                    data-id="<?= $p['id'] ?>"
                    data-name="<?= htmlspecialchars($p['name']) ?>"
                    data-price="<?= $p['price'] ?>"
                    data-image="<?= $BASE_URL ?>/images/<?= $p['image'] ?>">
                    Add to Cart
                </button>
            </div>

        </div>
        <?php endforeach; ?>

    </div>
</section>


<!-- ================= ZOOM MODAL ================= -->
<div id="mnZoomModal" class="mn-zoom-modal">
    <span id="mnZoomClose" class="mn-zoom-close">&times;</span>
    <img id="mnZoomImage" src="" alt="Zoomed product">
</div>

<?php
$content = ob_get_clean();
include "base.php";
?>