<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "config.php";
include_once "connection.php";

$cartCount = 0;

if (isset($_SESSION['user_id'])) {
    $userId = (int)$_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT COALESCE(SUM(quantity), 0) AS cart_count FROM basket_items WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $cartCount = (int)($row['cart_count'] ?? 0);
    $stmt->close();
} else {
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $cartCount += max(1, (int)($item['qty'] ?? 1));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? "6ixe7ven") ?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="<?= $BASE_URL ?>/css/base.css">
    <link rel="stylesheet" href="<?= $BASE_URL ?>/css/chatbot.css">
    <link rel="stylesheet" href="<?= $BASE_URL ?>/css/btn.css">

    <?= $extra_css ?? '' ?>

    <style>
        .account-menu-wrapper {
            position: relative;
            display: inline-block;
        }

        .account-dropdown {
            position: absolute;
            top: 48px;
            right: 0;
            min-width: 220px;
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            padding: 10px 0;
            display: none;
            z-index: 9999;
        }

        .account-dropdown.show {
            display: block;
        }

        .account-dropdown a,
        .account-dropdown button {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 12px 16px;
            background: none;
            border: none;
            text-decoration: none;
            color: #111;
            font-size: 14px;
            cursor: pointer;
            text-align: left;
        }

        .account-dropdown a:hover,
        .account-dropdown button:hover {
            background: #f7f7f7;
        }

        .account-dropdown .dropdown-user {
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
            margin-bottom: 6px;
        }

        .account-dropdown .dropdown-user strong {
            display: block;
            font-size: 14px;
            color: #111;
        }

        .account-dropdown .dropdown-user span {
            font-size: 12px;
            color: #666;
        }

        .account-dropdown .dropdown-divider {
            height: 1px;
            background: #eee;
            margin: 6px 0;
        }

        body.dark-mode .account-dropdown {
            background: #1e1e1e;
            border-color: #333;
        }

        body.dark-mode .account-dropdown a,
        body.dark-mode .account-dropdown button {
            color: #f0f0f0;
        }

        body.dark-mode .account-dropdown a:hover,
        body.dark-mode .account-dropdown button:hover {
            background: #2a2a2a;
        }

        body.dark-mode .account-dropdown .dropdown-user strong {
            color: #f0f0f0;
        }

        body.dark-mode .account-dropdown .dropdown-user span {
            color: #aaa;
        }

        body.dark-mode .account-dropdown .dropdown-divider {
            background: #333;
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="nav-container">

            <a href="<?= $BASE_URL ?>/index.php" class="nav-logo">
                <img src="<?= $BASE_URL ?>/images/6ixe7venLogo.png" alt="6ixe7ven Logo">
                <span>6IXE7VEN</span>
            </a>

            <nav class="nav-links">
                <a href="<?= $BASE_URL ?>/index.php">Home</a>
                <a href="<?= $BASE_URL ?>/men.php">Men</a>
                <a href="<?= $BASE_URL ?>/women.php">Women</a>

                <div class="nav-dropdown">
                    <button type="button" class="nav-dropbtn" id="shopDropBtn">
                        Shop <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div class="nav-dropdown-menu" id="shopDropMenu">
                        <a href="<?= $BASE_URL ?>/kids.php">Kids</a>
                        <a href="<?= $BASE_URL ?>/accessories.php">Accessories</a>
                        <a href="<?= $BASE_URL ?>/footwear.php">Footwear</a>
                        <a href="<?= $BASE_URL ?>/products.php">All Products</a>
                    </div>
                </div>
            </nav>

            <div class="right-side">

                <form action="<?= $BASE_URL ?>/search.php" method="GET" class="nav-search">
                    <input type="text" name="query" placeholder="Search..." autocomplete="off">
                    <button type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>

                <a href="<?= $BASE_URL ?>/cart.php" class="icon-btn cart-btn" title="Cart">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <?php if ($cartCount > 0): ?>
                        <span class="cart-count"><?= $cartCount ?></span>
                    <?php endif; ?>
                </a>

                <button class="theme-toggle" id="themeToggle" type="button">
                    <i id="themeIcon" class="fa-solid fa-moon"></i>
                </button>

                <button id="mobile-menu-btn" class="icon-btn mobile-toggle" type="button" aria-label="Open menu">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="account-menu-wrapper">
                        <button class="icon-btn" id="accountMenuBtn" type="button" title="My Account">
                            <i class="fa-solid fa-circle-user"></i>
                        </button>

                        <div class="account-dropdown" id="accountDropdown">
                            <div class="dropdown-user">
                                <strong><?= htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Account') ?></strong>
                                <span><?= htmlspecialchars($_SESSION['role'] ?? 'user') ?></span>
                            </div>

                            <a href="<?= $BASE_URL ?>/dashboard.php">
                                <i class="fa-solid fa-user"></i>
                                Dashboard
                            </a>

                            <a href="<?= $BASE_URL ?>/changePassword.php">
                                <i class="fa-solid fa-key"></i>
                                Change Password
                            </a>

                            <a href="<?= $BASE_URL ?>/orders.php">
                                <i class="fa-solid fa-box"></i>
                                My Orders
                            </a>

                            <a href="<?= $BASE_URL ?>/returns.php">
                                <i class="fa-solid fa-rotate-left"></i>
                                Returns
                            </a>

                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <a href="<?= $BASE_URL ?>/admin.php">
                                    <i class="fa-solid fa-shield-halved"></i>
                                    Admin Panel
                                </a>
                            <?php endif; ?>

                            <div class="dropdown-divider"></div>

                            <a href="<?= $BASE_URL ?>/logout.php">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                Logout
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= $BASE_URL ?>/login.php" class="icon-btn" title="Login">
                        <i class="fa-regular fa-user"></i>
                    </a>
                <?php endif; ?>

            </div>
        </div>

        <div class="mobile-menu" id="mobileMenu">
            <a href="<?= $BASE_URL ?>/index.php">Home</a>
            <a href="<?= $BASE_URL ?>/men.php">Men</a>
            <a href="<?= $BASE_URL ?>/women.php">Women</a>
            <a href="<?= $BASE_URL ?>/kids.php">Kids</a>
            <a href="<?= $BASE_URL ?>/accessories.php">Accessories</a>
            <a href="<?= $BASE_URL ?>/footwear.php">Footwear</a>
            <a href="<?= $BASE_URL ?>/products.php">All Products</a>
            <a href="<?= $BASE_URL ?>/cart.php">Cart</a>

            <form action="<?= $BASE_URL ?>/search.php" method="GET" class="nav-search">
                <input type="text" name="query" placeholder="Search..." autocomplete="off">
                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?= $BASE_URL ?>/dashboard.php">Dashboard</a>
                <a href="<?= $BASE_URL ?>/changePassword.php">Change Password</a>
                <a href="<?= $BASE_URL ?>/orders.php">My Orders</a>
                <a href="<?= $BASE_URL ?>/returns.php">Returns</a>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="<?= $BASE_URL ?>/admin.php">Admin Panel</a>
                <?php endif; ?>

                <a href="<?= $BASE_URL ?>/logout.php">Logout</a>
            <?php else: ?>
                <a href="<?= $BASE_URL ?>/login.php">Login</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="page-content">
        <?= $content ?? "" ?>
    </main>

    <footer class="footer">
        <div class="footer-grid">

            <div class="footer-about">
                <img src="<?= $BASE_URL ?>/images/6ixe7venLogo.png" alt="6ixe7ven Logo">
                <p>Premium streetwear. Designed for those who create their own path.</p>
            </div>

            <div>
                <h4>Shop</h4>
                <a href="<?= $BASE_URL ?>/men.php">Men</a>
                <a href="<?= $BASE_URL ?>/women.php">Women</a>
                <a href="<?= $BASE_URL ?>/kids.php">Kids</a>
                <a href="<?= $BASE_URL ?>/accessories.php">Accessories</a>
                <a href="<?= $BASE_URL ?>/footwear.php">Footwear</a>
                <a href="<?= $BASE_URL ?>/products.php">All Products</a>
            </div>

            <div>
                <h4>Support</h4>
                <a href="<?= $BASE_URL ?>/contact.php">Contact</a>
                <a href="<?= $BASE_URL ?>/shipping.php">Shipping</a>
                <a href="<?= $BASE_URL ?>/returns.php">Returns</a>
            </div>

            <div>
                <h4>Company</h4>
                <a href="<?= $BASE_URL ?>/about.php">About Us</a>
                <a href="<?= $BASE_URL ?>/privacy.php">Privacy Policy</a>
                <a href="<?= $BASE_URL ?>/terms.php">Terms</a>
            </div>

        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 6IXE7VEN All Rights Reserved.</p>
        </div>
    </footer>

    <div id="chatbot-toggle">
        <img src="<?= $BASE_URL ?>/images/6ixe7venLogo.png" alt="Chatbot Logo">
    </div>

    <div id="chatbot-box">
        <div class="chatbot-header">
            <img src="<?= $BASE_URL ?>/images/6ixe7venLogo.png" class="chatbot-header-logo" alt="6ixe7ven Logo">
            <span>6IXE7VEN Assistant</span>
            <button id="chatbot-close" type="button">&times;</button>
        </div>

        <div class="chatbot-messages"></div>

        <div class="chatbot-input">
            <input type="text" id="chatbot-user-input" placeholder="Type your message...">
            <button id="chatbot-send" type="button">Send</button>
        </div>
    </div>

    <script src="<?= $BASE_URL ?>/js/base.js"></script>
    <script src="<?= $BASE_URL ?>/js/chatbot.js"></script>

    <?= $extra_js ?? '' ?>

    <button id="scrollTopBtn" title="Back to top" type="button">↑</button>

    <script>
        /* ── Scroll to top ── */
        const scrollBtn = document.getElementById("scrollTopBtn");
        window.onscroll = function () {
            scrollBtn.style.display = (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200)
                ? "block" : "none";
        };
        scrollBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

        /* ── Dark / Light mode ── */
        const themeToggle = document.getElementById("themeToggle");
        const themeIcon   = document.getElementById("themeIcon");

        if (localStorage.getItem("theme") === "dark") {
            document.body.classList.add("dark-mode");
            themeIcon.classList.replace("fa-moon", "fa-sun");
        }

        if (themeToggle) {
            themeToggle.addEventListener("click", function () {
                const isDark = document.body.classList.toggle("dark-mode");
                themeIcon.classList.replace(isDark ? "fa-moon" : "fa-sun", isDark ? "fa-sun" : "fa-moon");
                localStorage.setItem("theme", isDark ? "dark" : "light");
            });
        }

        /* ── Shop dropdown (desktop click-based) ── */
        const shopDropBtn  = document.getElementById("shopDropBtn");
        const shopDropMenu = document.getElementById("shopDropMenu");

        if (shopDropBtn && shopDropMenu) {
            shopDropBtn.addEventListener("click", function (e) {
                e.stopPropagation();
                const isOpen = shopDropMenu.classList.toggle("open");
                shopDropBtn.classList.toggle("open", isOpen);
            });

            /* Close when clicking anywhere outside */
            document.addEventListener("click", function (e) {
                if (!shopDropMenu.contains(e.target) && !shopDropBtn.contains(e.target)) {
                    shopDropMenu.classList.remove("open");
                    shopDropBtn.classList.remove("open");
                }
            });

            /* Close when pressing Escape */
            document.addEventListener("keydown", function (e) {
                if (e.key === "Escape") {
                    shopDropMenu.classList.remove("open");
                    shopDropBtn.classList.remove("open");
                }
            });
        }

        /* ── Account dropdown ── */
        const accountMenuBtn  = document.getElementById("accountMenuBtn");
        const accountDropdown = document.getElementById("accountDropdown");

        if (accountMenuBtn && accountDropdown) {
            accountMenuBtn.addEventListener("click", e => {
                e.stopPropagation();
                accountDropdown.classList.toggle("show");
            });
            document.addEventListener("click", e => {
                if (!accountDropdown.contains(e.target) && !accountMenuBtn.contains(e.target)) {
                    accountDropdown.classList.remove("show");
                }
            });
        }

        /* ── Mobile menu ── */
        const mobileMenuBtn = document.getElementById("mobile-menu-btn");
        const mobileMenu    = document.getElementById("mobileMenu");

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener("click", e => {
                e.stopPropagation();
                mobileMenu.classList.toggle("open");
            });
            document.addEventListener("click", e => {
                if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                    mobileMenu.classList.remove("open");
                }
            });
        }
    </script>

</body>
</html>