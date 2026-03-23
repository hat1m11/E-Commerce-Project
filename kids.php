<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "connection.php";
include_once "config.php";

$title     = "Kids - 6ixe7ven";
$extra_css = '
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/kids.css">
';

$extra_js = '
<script>window.BASE_URL = ' . json_encode($BASE_URL ?? '') . ';</script>
<script src="js/cart.js"></script>
<script src="js/kids.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {

    const cards      = document.querySelectorAll(".kd-card");
    const typeFilter = document.getElementById("typeFilter");
    const sortSelect = document.getElementById("sortSelect");
    const grid       = document.querySelector(".kd-grid");
    const countEl    = document.getElementById("kd-count");

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
    const zoomModal = document.getElementById("kdZoomModal");
    const zoomImage = document.getElementById("kdZoomImage");
    const zoomClose = document.getElementById("kdZoomClose");

    document.querySelectorAll(".kd-card-img img").forEach(img => {
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
    ["id" => 301, "name" => "Kids Hoodie",      "price" => 29.99, "image" => "khoodie1.jpeg",    "type" => "Hoodie",    "badge" => "New In"],
    ["id" => 302, "name" => "Kids Tracksuit",   "price" => 44.99, "image" => "ktracksuit1.jpeg", "type" => "Tracksuit", "badge" => "Bestseller"],
    ["id" => 303, "name" => "Kids T-shirt",     "price" => 16.99, "image" => "ktshirt1.jpeg",    "type" => "T-shirt",   "badge" => ""],
    ["id" => 304, "name" => "Kids Jacket",      "price" => 49.99, "image" => "kjacket1.jpeg",    "type" => "Jacket",    "badge" => "Limited"],
    ["id" => 305, "name" => "Kids Joggers",     "price" => 24.99, "image" => "kjoggers1.jpeg",   "type" => "Joggers",   "badge" => ""],
];

ob_start();
?>


<section class="kd-hero">
    <div class="kd-hero-inner">
        <p class="kd-hero-eyebrow">6ixe7ven Collection</p>
        <h1 class="kd-hero-title">Kids</h1>
        <p class="kd-hero-sub">Streetwear designed for comfort, movement, and everyday style.</p>
    </div>
</section>



<section class="kd-section">

    <div class="kd-toolbar">

        <div class="kd-control-group">
            <label for="typeFilter">Category</label>
            <select id="typeFilter" class="kd-select">
                <option value="All">All</option>
                <option value="Hoodie">Hoodie</option>
                <option value="Tracksuit">Tracksuit</option>
                <option value="T-shirt">T-shirt</option>
                <option value="Jacket">Jacket</option>
                <option value="Joggers">Joggers</option>
            </select>
        </div>

        <div class="kd-control-group">
            <label for="sortSelect">Sort by</label>
            <select id="sortSelect" class="kd-select">
                <option value="default">Featured</option>
                <option value="priceLow">Price: Low &rarr; High</option>
                <option value="priceHigh">Price: High &rarr; Low</option>
                <option value="newest">Newest</option>
            </select>
        </div>

        <span id="kd-count" class="kd-count"><?= count($products) ?> products</span>

    </div>

    <div class="kd-grid">

        <?php foreach ($products as $p): ?>
        <div class="kd-card"
             data-type="<?= htmlspecialchars($p['type']) ?>"
             data-price="<?= $p['price'] ?>">

            <div class="kd-card-img">
                <?php if (!empty($p['badge'])): ?>
                    <span class="kd-badge"><?= htmlspecialchars($p['badge']) ?></span>
                <?php endif; ?>
                <a href="<?= $BASE_URL ?>/single_product.php?id=<?= $p['id'] ?>">
                    <img src="<?= $BASE_URL ?>/images/<?= htmlspecialchars($p['image']) ?>"
                         alt="<?= htmlspecialchars($p['name']) ?>"
                         onerror="this.onerror=null;this.src='<?= $BASE_URL ?>/images/6ixe7venLogo.png';">
                </a>
            </div>

            <div class="kd-card-body">
                <span class="kd-card-type"><?= htmlspecialchars($p['type']) ?></span>
                <h3 class="kd-card-name">
                   <a href="<?= $BASE_URL ?>/single_product.php?id=<?= $p['id'] ?>">
                        <?= htmlspecialchars($p['name']) ?>
                    </a>
                </h3>
                <p class="kd-card-price">&pound;<?= number_format($p['price'], 2) ?></p>
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



<div id="kdZoomModal" class="kd-zoom-modal">
    <span id="kdZoomClose" class="kd-zoom-close">&times;</span>
    <img id="kdZoomImage" src="" alt="Zoomed product">
</div>

<?php
$content = ob_get_clean();
include "base.php";
?>