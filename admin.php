<?php
$title = "Admin - 6ixe7ven";
$extra_css = "";
require_once __DIR__ . "/backend/middleware/adminOnly.php";
ob_start();
?>

<style>
/* ── Page header ─────────────────────────────── */
.admin-dash { padding: 0; }

.dash-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #e1e4e8;
}
.dash-header .page-title {
    font-size: 32px;
    font-weight: 700;
    color: #3d4f66;
    margin-bottom: 6px;
}
.dash-header .page-subtitle {
    font-size: 15px;
    color: #6b7a8f;
}

/* ── Tile grid ───────────────────────────────── */
.tile-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 30px;
}

.tile {
    border-radius: 14px;
    padding: 32px 28px 28px;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    gap: 6px;
    position: relative;
    overflow: hidden;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.tile:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(61, 79, 102, 0.18);
}

/* ── Hero tiles (dark) ───────────────────────── */
.tile-hero {
    background: #3d4f66;
    min-height: 160px;
}
.tile-hero.tile-inventory {
    background: #4a5d7a;
}
.tile-hero .tile-icon {
    font-size: 36px;
    margin-bottom: 6px;
    display: block;
}
.tile-hero .tile-title {
    font-size: 20px;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
}
.tile-hero .tile-desc {
    font-size: 13px;
    color: #b8c5d6;
    margin: 0;
}
.tile-hero .tile-cta {
    margin-top: 14px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.15);
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    padding: 7px 14px;
    border-radius: 7px;
    transition: background 0.2s ease;
    align-self: flex-start;
}
.tile-hero:hover .tile-cta {
    background: rgba(255,255,255,0.25);
}

/* ── Bottom 3-column row ─────────────────────── */
.tile-grid-bottom {
    grid-column: 1 / -1;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

/* ── Secondary tiles ─────────────────────────── */
.tile-secondary {
    background: #ffffff;
    border: 1px solid #e8ecf1;
    box-shadow: 0 4px 12px rgba(74, 93, 122, 0.07);
    min-height: 130px;
    padding-top: 20px;
    text-align: center;
    align-items: center;
    justify-content: center;
}
.tile-secondary::before {
    content: '';
    display: block;
    width: 100%;
    height: 4px;
    position: absolute;
    top: 0;
    left: 0;
    border-radius: 14px 14px 0 0;
}
.tile-customers::before { background: linear-gradient(90deg, #faad14, #ffc53d); }
.tile-contacts::before  { background: linear-gradient(90deg, #ff4d4f, #ff7875); }
.tile-returns::before   { background: linear-gradient(90deg, #722ed1, #9254de); }

.tile-secondary .tile-icon {
    font-size: 30px;
    display: block;
    margin-bottom: 8px;
}
.tile-secondary .tile-title {
    font-size: 16px;
    font-weight: 700;
    color: #3d4f66;
    margin: 0 0 4px;
}
.tile-secondary .tile-desc {
    font-size: 12px;
    color: #6b7a8f;
    margin: 0 0 10px;
}
.tile-secondary .tile-cta {
    font-size: 13px;
    font-weight: 600;
    color: #4a5d7a;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: gap 0.2s ease;
}
.tile-secondary:hover .tile-cta { gap: 8px; }

/* ── Footer nav ──────────────────────────────── */
.dash-footer-nav {
    margin-top: 10px;
    padding-top: 20px;
    border-top: 2px solid #e1e4e8;
    display: flex;
    gap: 6px;
    align-items: center;
    flex-wrap: wrap;
}
.dash-footer-nav a {
    color: #4a5d7a;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: color 0.2s;
}
.dash-footer-nav a:hover {
    color: #3d4f66;
    text-decoration: underline;
}
.dash-footer-nav .sep {
    color: #d6dde6;
    font-size: 14px;
}

/* ── Responsive ──────────────────────────────── */
@media (max-width: 860px) {
    .tile-grid          { grid-template-columns: 1fr; }
    .tile-grid-bottom   { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
    .tile-grid-bottom   { grid-template-columns: 1fr 1fr; }
}
</style>

<section class="admin-dash">

    <!-- Header -->
    <div class="dash-header">
        <h1 class="page-title">Admin Dashboard</h1>
        <p class="page-subtitle">Manage orders, customers, inventory, contact messages, and returns.</p>
    </div>

    <!-- Tile grid -->
    <div class="tile-grid">

        <!-- Hero: Process Orders -->
        <a href="adminOrders.php" class="tile tile-hero">
            <span class="tile-icon">📦</span>
            <h2 class="tile-title">Process Orders</h2>
            <p class="tile-desc">Fulfil, ship &amp; track customer orders</p>
            <span class="tile-cta">Open &rarr;</span>
        </a>

        <!-- Hero: Inventory -->
        <a href="adminInventory.php" class="tile tile-hero tile-inventory">
            <span class="tile-icon">📋</span>
            <h2 class="tile-title">Inventory Management</h2>
            <p class="tile-desc">Stock levels, SKUs &amp; product listings</p>
            <span class="tile-cta">Manage &rarr;</span>
        </a>

        <!-- Secondary bottom row (3-up) -->
        <div class="tile-grid-bottom">

            <a href="adminCustomers.php" class="tile tile-secondary tile-customers">
                <span class="tile-icon">👥</span>
                <h2 class="tile-title">Customers</h2>
                <p class="tile-desc">Accounts &amp; order history</p>
                <span class="tile-cta">View &rarr;</span>
            </a>

            <a href="adminContacts.php" class="tile tile-secondary tile-contacts">
                <span class="tile-icon">✉️</span>
                <h2 class="tile-title">Contact Inbox</h2>
                <p class="tile-desc">Messages from customers</p>
                <span class="tile-cta">Open &rarr;</span>
            </a>

            <a href="adminReturns.php" class="tile tile-secondary tile-returns">
                <span class="tile-icon">↩️</span>
                <h2 class="tile-title">Returns</h2>
                <p class="tile-desc">Process refunds &amp; exchanges</p>
                <span class="tile-cta">Review &rarr;</span>
            </a>

        </div>

    </div>

    <!-- Footer nav -->
    <nav class="dash-footer-nav">
        <a href="orders.php">Customer Orders Page</a>
        <span class="sep">|</span>
        <a href="products.php">Shop Products Page</a>
        <span class="sep">|</span>
        <a href="dashboard.php">Back to Dashboard</a>
    </nav>

</section>

<?php
$content = ob_get_clean();
include "base.php";
?>