<?php
$title = "Admin Inventory - 6ixe7ven";
$extra_css = "";

require_once __DIR__ . "/backend/middleware/adminOnly.php";
require_once "connection.php";
include_once "config.php";

if (!isset($BASE_URL) || !is_string($BASE_URL)) {
    $BASE_URL = "";
}

$error = "";
$success = "";
$lowThreshold = 5;

function resolveImage(string $raw, string $baseUrl): string
{
    $raw = trim($raw);
    $base = rtrim($baseUrl, "/");

    if ($raw === "") {
        return $base . "/images/6ixe7venLogo.png";
    }

    if (preg_match('/^https?:\/\//i', $raw)) {
        return $raw;
    }

    if (strpos($raw, "static/images/") === 0) {
        $raw = "images/" . substr($raw, strlen("static/images/"));
    }

    $raw = ltrim($raw, "/");
    return $base . "/" . $raw;
}

function badgeText(int $stock, int $lowThreshold): string
{
    if ($stock <= 0) return "Out of stock";
    if ($stock <= $lowThreshold) return "Low stock";
    return "In stock";
}

function validMoney(string $value): bool
{
    return $value !== "" && is_numeric($value) && (float)$value >= 0;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";

    if ($action === "restock") {
        $productId = (int)($_POST["product_id"] ?? 0);
        $delta = (int)($_POST["add_qty"] ?? 0);

        if ($productId <= 0 || $delta === 0) {
            $error = "Enter a valid quantity to add/remove.";
        } else {
            $stmt = $conn->prepare("UPDATE products SET stock = stock + ? WHERE product_id = ?");
            $stmt->bind_param("ii", $delta, $productId);

            if ($stmt->execute()) {
                $success = "Stock updated for product #{$productId}.";
            } else {
                $error = "Could not update stock.";
            }
            $stmt->close();
        }
    }

    if ($action === "setstock") {
        $productId = (int)($_POST["product_id"] ?? 0);
        $newStock = (int)($_POST["new_stock"] ?? -1);

        if ($productId <= 0 || $newStock < 0) {
            $error = "Enter a valid stock amount (0 or higher).";
        } else {
            $stmt = $conn->prepare("UPDATE products SET stock = ? WHERE product_id = ?");
            $stmt->bind_param("ii", $newStock, $productId);

            if ($stmt->execute()) {
                $success = "Stock set for product #{$productId}.";
            } else {
                $error = "Could not set stock.";
            }
            $stmt->close();
        }
    }

    if ($action === "edit") {
        $productId = (int)($_POST["product_id"] ?? 0);

        $name = trim($_POST["name"] ?? "");
        $priceRaw = trim($_POST["price"] ?? "");
        $image = trim($_POST["image"] ?? "");
        $description = trim($_POST["description"] ?? "");
        $category = trim($_POST["category"] ?? "");

        if ($productId <= 0 || $name === "" || $image === "" || !validMoney($priceRaw)) {
            $error = "Name, image, and a valid price are required.";
        } else {
            $price = (float)$priceRaw;

            $stmt = $conn->prepare("
                UPDATE products
                SET name = ?, price = ?, image = ?, description = ?, category = ?
                WHERE product_id = ?
            ");
            $stmt->bind_param("sdsssi", $name, $price, $image, $description, $category, $productId);

            if ($stmt->execute()) {
                $success = "Product #{$productId} updated.";
            } else {
                $error = "Could not update product.";
            }
            $stmt->close();
        }
    }

    if ($action === "delete") {
        $productId = (int)($_POST["product_id"] ?? 0);

        if ($productId <= 0) {
            $error = "Invalid product id.";
        } else {
            $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
            $stmt->bind_param("i", $productId);

            if ($stmt->execute()) {
                $success = "Product #{$productId} deleted.";
            } else {
                $error = "Could not delete product (it may be linked to orders).";
            }
            $stmt->close();
        }
    }
}

$search = trim($_GET["search"] ?? "");
$cat = trim($_GET["cat"] ?? "");

$categoryOptions = [];
$resCats = $conn->query("
    SELECT DISTINCT category
    FROM products
    WHERE category IS NOT NULL AND category <> ''
    ORDER BY category ASC
");
if ($resCats) {
    while ($r = $resCats->fetch_assoc()) $categoryOptions[] = $r["category"];
    $resCats->free();
}

$sql = "SELECT product_id, name, price, image, description, category, stock, created_at FROM products";
$where = [];
$params = [];
$types = "";

if ($search !== "") {
    $where[] = "name LIKE ?";
    $params[] = "%" . $search . "%";
    $types .= "s";
}

if ($cat !== "") {
    $where[] = "category = ?";
    $params[] = $cat;
    $types .= "s";
}

if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY created_at DESC";

$products = [];
if ($params) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) $products[] = $row;
    $stmt->close();
} else {
    $res = $conn->query($sql);
    if ($res) {
        while ($row = $res->fetch_assoc()) $products[] = $row;
        $res->free();
    }
}

ob_start();
?>

<section style="padding:30px;">
    <h1>Inventory Management</h1>
    <p>Manage product stock and details.</p>

    <div style="margin: 12px 0; display:flex; gap:10px; flex-wrap:wrap;">
        <a href="admin.php">← Back to Admin</a>
        <a href="adminAddProduct.php" style="padding:8px 12px; background:#111; color:#fff; border-radius:8px; text-decoration:none;">
            + Add Product
        </a>
    </div>

    <?php if ($error !== ""): ?>
        <div style="background:#ffe5e5; padding:10px; border-radius:8px; margin:12px 0;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($success !== ""): ?>
        <div style="background:#e7ffe5; padding:10px; border-radius:8px; margin:12px 0;">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <form method="GET" action="adminInventory.php" style="display:flex; gap:10px; flex-wrap:wrap; margin:16px 0;">
        <input type="text" name="search" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>" style="padding:10px; min-width:220px;">

        <select name="cat" style="padding:10px;">
            <option value="">All categories</option>
            <?php foreach ($categoryOptions as $opt): ?>
                <option value="<?= htmlspecialchars($opt) ?>" <?= ($cat === $opt) ? "selected" : "" ?>>
                    <?= htmlspecialchars($opt) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" style="padding:10px 14px; cursor:pointer;">Filter</button>
        <a href="adminInventory.php" style="padding:10px 14px; display:inline-block;">Reset</a>
    </form>

    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; background:#fff; border-radius:10px; overflow:hidden;">
            <thead>
                <tr style="text-align:left; background:#f3f3f3;">
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Product</th>
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Category</th>
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Price</th>
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Stock</th>
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Stock Actions</th>
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Edit</th>
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!$products): ?>
                    <tr><td colspan="7" style="padding:12px;">No products found.</td></tr>
                <?php endif; ?>

                <?php foreach ($products as $p): ?>
                    <?php
                        $pid = (int)$p["product_id"];
                        $stock = (int)$p["stock"];
                        $badge = badgeText($stock, $lowThreshold);
                        $img = resolveImage((string)$p["image"], $BASE_URL);
                    ?>

                    <tr>
                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <div style="display:flex; gap:12px; align-items:flex-start;">
                                <img
                                    src="<?= htmlspecialchars($img) ?>"
                                    alt="Product image"
                                    style="width:56px; height:56px; object-fit:cover; border-radius:8px;"
                                    onerror="this.onerror=null; this.src='<?= htmlspecialchars(rtrim($BASE_URL,'/')) ?>/images/6ixe7venLogo.png';"
                                >
                                <div>
                                    <strong><?= htmlspecialchars($p["name"]) ?></strong><br>
                                    <small style="color:#555;"><?= htmlspecialchars($p["description"] ?? "") ?></small>
                                    <div style="margin-top:6px;">
                                        <span style="padding:4px 8px; border-radius:999px; background:#111; color:#fff; font-size:12px;">
                                            <?= htmlspecialchars($badge) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <?= htmlspecialchars($p["category"] ?? "—") ?>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            £<?= htmlspecialchars($p["price"]) ?>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <strong><?= $stock ?></strong>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <form method="POST" action="adminInventory.php" style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                                <input type="hidden" name="action" value="restock">
                                <input type="hidden" name="product_id" value="<?= $pid ?>">
                                <input type="number" name="add_qty" placeholder="+/- qty" style="width:90px; padding:8px;" required>
                                <button type="submit" style="padding:8px 10px; cursor:pointer;">Apply</button>
                            </form>

                            <form method="POST" action="adminInventory.php" style="display:flex; gap:8px; flex-wrap:wrap; align-items:center; margin-top:8px;">
                                <input type="hidden" name="action" value="setstock">
                                <input type="hidden" name="product_id" value="<?= $pid ?>">
                                <input type="number" name="new_stock" min="0" placeholder="Set stock" style="width:90px; padding:8px;" required>
                                <button type="submit" style="padding:8px 10px; cursor:pointer;">Set</button>
                            </form>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <details>
                                <summary style="cursor:pointer;">Edit</summary>
                                <form method="POST" action="adminInventory.php" style="margin-top:10px; display:grid; gap:8px;">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="product_id" value="<?= $pid ?>">

                                    <input type="text" name="name" value="<?= htmlspecialchars($p["name"]) ?>" style="padding:8px;" required>
                                    <input type="text" name="price" value="<?= htmlspecialchars($p["price"]) ?>" style="padding:8px;" required>
                                    <input type="text" name="image" value="<?= htmlspecialchars($p["image"]) ?>" style="padding:8px;" required>
                                    <input type="text" name="category" value="<?= htmlspecialchars($p["category"] ?? "") ?>" style="padding:8px;">
                                    <textarea name="description" style="padding:8px; min-height:70px;"><?= htmlspecialchars($p["description"] ?? "") ?></textarea>

                                    <button type="submit" style="padding:8px 10px; cursor:pointer;">Save changes</button>
                                </form>
                            </details>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <form method="POST" action="adminInventory.php" onsubmit="return confirm('Delete this product?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="product_id" value="<?= $pid ?>">
                                <button type="submit" style="padding:8px 10px; cursor:pointer; background:#b00020; color:#fff; border:none; border-radius:8px;">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top:14px; color:#555;">
        <small>Low stock warning shows at ≤ <strong><?= (int)$lowThreshold ?></strong>.</small>
    </div>
</section>

<?php
$content = ob_get_clean();
include "base.php";
?>