<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "connection.php";
include_once "config.php";

$title     = "Footwear - 6ixe7ven";
$extra_css = '
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/footwear.css">
';

$extra_js = '
<script>window.BASE_URL = ' . json_encode($BASE_URL ?? '') . ';</script>
<script src="js/cart.js"></script>
<script src="js/footwear.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {

    const cards      = document.querySelectorAll(".fw-card");
    const typeFilter = document.getElementById("typeFilter");
    const sortSelect = document.getElementById("sortSelect");
    const grid       = document.querySelector(".fw-grid");
    const countEl    = document.getElementById("fw-count");

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
    const zoomModal = document.getElementById("fwZoomModal");
    const zoomImage = document.getElementById("fwZoomImage");
    const zoomClose = document.getElementById("fwZoomClose");

    document.querySelectorAll(".fw-card-img img").forEach(img => {
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
    ["id" => 501, "name" => "6ixe7ven Trainers 1", "price" => 79.99, "image" => "trainers1.jpeg", "type" => "Trainers", "badge" => "New In"],
    ["id" => 502, "name" => "6ixe7ven Sneakers 1", "price" => 69.99, "image" => "sneakers1.jpeg", "type" => "Sneakers", "badge" => "Bestseller"],
    ["id" => 503, "name" => "6ixe7ven Slides 1", "price" => 34.99, "image" => "slides1.jpeg", "type" => "Slides", "badge" => ""],
    ["id" => 504, "name" => "6ixe7ven Runners 1", "price" => 89.99, "image" => "runners1.jpeg", "type" => "Runners", "badge" => "Limited"],
    ["id" => 505, "name" => "6ixe7ven Boots 1", "price" => 99.99, "image" => "boots1.jpeg", "type" => "Boots", "badge" => ""],
];

ob_start();
?>

<!-- ================= HERO ================= -->
<section class="fw-hero">
    <div class="fw-hero-inner">
        <p class="fw-hero-eyebrow">6ixe7ven Collection</p>
        <h1 class="fw-hero-title">Footwear</h1>
        <p class="fw-hero-sub">Step into premium footwear designed to elevate your everyday fit.</p>
    </div>
</section>


<!-- ================= TOOLBAR + GRID ================= -->
<section class="fw-section">

    <div class="fw-toolbar">

        <div class="fw-control-group">
            <label for="typeFilter">Category</label>
            <select id="typeFilter" class="fw-select">
                <option value="All">All</option>
                <option value="Trainers">Trainers</option>
                <option value="Sneakers">Sneakers</option>
                <option value="Slides">Slides</option>
                <option value="Runners">Runners</option>
                <option value="Boots">Boots</option>
            </select>
        </div>

        <div class="fw-control-group">
            <label for="sortSelect">Sort by</label>
            <select id="sortSelect" class="fw-select">
                <option value="default">Featured</option>
                <option value="priceLow">Price: Low &rarr; High</option>
                <option value="priceHigh">Price: High &rarr; Low</option>
                <option value="newest">Newest</option>
            </select>
        </div>

        <span id="fw-count" class="fw-count"><?= count($products) ?> products</span>

    </div>

    <div class="fw-grid">

        <?php foreach ($products as $p): ?>
        <div class="fw-card"
             data-type="<?= htmlspecialchars($p['type']) ?>"
             data-price="<?= $p['price'] ?>">

            <div class="fw-card-img">
                <?php if (!empty($p['badge'])): ?>
                    <span class="fw-badge"><?= htmlspecialchars($p['badge']) ?></span>
                <?php endif; ?>
                <a href="<?= $BASE_URL ?>/single_product.php?id=<?= $p['id'] ?>">
                    <img src="<?= $BASE_URL ?>/images/<?= htmlspecialchars($p['image']) ?>"
                         alt="<?= htmlspecialchars($p['name']) ?>"
                         onerror="this.onerror=null;this.src='<?= $BASE_URL ?>/images/6ixe7venLogo.png';">
                </a>
            </div>

            <div class="fw-card-body">
                <span class="fw-card-type"><?= htmlspecialchars($p['type']) ?></span>
                <h3 class="fw-card-name">
                    <a href="<?= $BASE_URL ?>/single_product.php?id=<?= $p['id'] ?>">
                        <?= htmlspecialchars($p['name']) ?>
                    </a>
                </h3>
                <p class="fw-card-price">&pound;<?= number_format($p['price'], 2) ?></p>
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
<div id="fwZoomModal" class="fw-zoom-modal">
    <span id="fwZoomClose" class="fw-zoom-close">&times;</span>
    <img id="fwZoomImage" src="" alt="Zoomed product">
</div>

<?php
$content = ob_get_clean();
include "base.php";
?>