<?php
include_once "config.php";

$title     = "Women's Collection - 6ixe7ven";
$extra_css = '
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="' . $BASE_URL . '/css/women.css">
';

$extra_js = '
<script>window.BASE_URL = ' . json_encode($BASE_URL ?? '') . ';</script>
<script src="' . $BASE_URL . '/js/cart.js"></script>
<script src="' . $BASE_URL . '/js/women.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {

    const cards      = document.querySelectorAll(".wm-card");
    const typeFilter = document.getElementById("typeFilter");
    const sortSelect = document.getElementById("sortSelect");
    const grid       = document.querySelector(".wm-grid");
    const countEl    = document.getElementById("wm-count");

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
    const zoomModal = document.getElementById("wmZoomModal");
    const zoomImage = document.getElementById("wmZoomImage");
    const zoomClose = document.getElementById("wmZoomClose");

    document.querySelectorAll(".wm-card-img img").forEach(img => {
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
    ["id" => 201, "name" => "Women's Hoodie 1",  "price" => 39.99, "image" => "whoodie1.jpeg", "type" => "Hoodie",  "badge" => "New In"],
    ["id" => 202, "name" => "Women's Jeans",      "price" => 49.99, "image" => "wjeans1.jpeg",  "type" => "Jeans",   "badge" => "Bestseller"],
    ["id" => 203, "name" => "Women's T-shirt 1",  "price" => 19.99, "image" => "wtshirt1.jpeg", "type" => "T-shirt", "badge" => ""],
    ["id" => 204, "name" => "Women's Hoodie 2",   "price" => 44.99, "image" => "whoodie2.jpeg", "type" => "Hoodie",  "badge" => "Limited"],
    ["id" => 205, "name" => "Women's T-shirt 2",  "price" => 19.99, "image" => "wtshirt2.jpeg", "type" => "T-shirt", "badge" => ""],
];

ob_start();
?>

<section class="wm-heading">
    <div class="wm-heading-inner">

        <div class="wm-breadcrumb">
            <a href="<?= $BASE_URL ?>/index.php">Home</a>
            <span>&rsaquo;</span>
            <span>Women</span>
        </div>

        <div class="wm-heading-row">
            <h1 class="wm-title">Women's Collection</h1>
            <span id="wm-count" class="wm-count"><?= count($products) ?> products</span>
        </div>

        <div class="wm-controls">

            <div class="wm-control-group">
                <label for="typeFilter">Category</label>
                <select id="typeFilter" class="wm-select">
                    <option value="All">All</option>
                    <option value="Hoodie">Hoodies</option>
                    <option value="T-shirt">T-shirts</option>
                    <option value="Jeans">Jeans</option>
                </select>
            </div>

            <div class="wm-control-group">
                <label for="sortSelect">Sort by</label>
                <select id="sortSelect" class="wm-select">
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
<section class="wm-grid-section">
    <div class="wm-grid" id="wm-grid">

        <?php foreach ($products as $p): ?>
        <div class="wm-card"
             data-type="<?= htmlspecialchars($p['type']) ?>"
             data-price="<?= $p['price'] ?>">

            <div class="wm-card-img">
                <?php if (!empty($p['badge'])): ?>
                    <span class="wm-badge"><?= htmlspecialchars($p['badge']) ?></span>
                <?php endif; ?>
                <a href="<?= $BASE_URL ?>/single_product.php?id=<?= $p['id'] ?>">
                    <img src="<?= $BASE_URL ?>/images/<?= htmlspecialchars($p['image']) ?>"
                         alt="<?= htmlspecialchars($p['name']) ?>"
                         onerror="this.onerror=null;this.src='<?= $BASE_URL ?>/images/6ixe7venLogo.png';">
                </a>
            </div>

            <div class="wm-card-body">
                <span class="wm-card-type"><?= htmlspecialchars($p['type']) ?></span>
                <h3 class="wm-card-name">
                    <a href="<?= $BASE_URL ?>/single_product.php?id=<?= $p['id'] ?>">
                        <?= htmlspecialchars($p['name']) ?>
                    </a>
                </h3>
                <p class="wm-card-price">&pound;<?= number_format($p['price'], 2) ?></p>
                <button class="add-btn"
                    data-id="<?= $p['id'] ?>"
                    data-name="<?= htmlspecialchars($p['name']) ?>"
                    data-price="<?= $p['price'] ?>"
                    data-image="<?= $BASE_URL ?>/images/<?= htmlspecialchars($p['image']) ?>">
                    Add to Cart
                </button>
            </div>

        </div>
        <?php endforeach; ?>

    </div>
</section>


<!-- ================= ZOOM MODAL ================= -->
<div id="wmZoomModal" class="wm-zoom-modal">
    <span id="wmZoomClose" class="wm-zoom-close">&times;</span>
    <img id="wmZoomImage" src="" alt="Zoomed product">
</div>

<?php
$content = ob_get_clean();
include "base.php";
?>