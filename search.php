<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "connection.php";

$title = "Search Results - 6ixe7ven";
$extra_css = '<link rel="stylesheet" href="css/products.css">';

$query = trim($_GET['query'] ?? '');
$products = [];

if ($query !== '') {
    $searchTerm = "%" . $query . "%";

    $stmt = $conn->prepare("
        SELECT product_id, name, price, image, description, category, stock
        FROM products
        WHERE name LIKE ? OR category LIKE ? OR description LIKE ?
        ORDER BY name ASC
    ");
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $stmt->close();
}

ob_start();
?>

<section style="padding: 40px 20px; max-width: 1200px; margin: 0 auto;">
    <h1 style="margin-bottom: 10px;">Search Results</h1>

    <?php if ($query === ''): ?>
        <p>Please enter a search term.</p>
    <?php else: ?>
        <p style="margin-bottom: 25px;">
            Results for: <strong><?= htmlspecialchars($query) ?></strong>
        </p>

        <?php if (count($products) > 0): ?>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:20px;">
                <?php foreach ($products as $product): ?>
                    <div style="border:1px solid #ddd; border-radius:12px; padding:15px; background:#fff;">
                        <img
                            src="<?= htmlspecialchars($product['image']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>"
                            style="width:100%; height:250px; object-fit:cover; border-radius:8px;"
                        >

                        <h3 style="margin:15px 0 8px;">
                            <?= htmlspecialchars($product['name']) ?>
                        </h3>

                        <p style="margin:0 0 6px; color:#666;">
                            Category: <?= htmlspecialchars($product['category'] ?? 'N/A') ?>
                        </p>

                        <p style="margin:0 0 6px; font-weight:600;">
                            £<?= number_format((float)$product['price'], 2) ?>
                        </p>

                        <p style="margin:0 0 10px; color:#555;">
                            <?= htmlspecialchars($product['description'] ?? 'No description available.') ?>
                        </p>

                        <p style="margin:0 0 15px; color:#444;">
                            Stock: <?= (int)$product['stock'] ?>
                        </p>

                        <a href="product_detail.php?id=<?= (int)$product['product_id'] ?>" style="display:inline-block; padding:10px 14px; background:#111; color:#fff; text-decoration:none; border-radius:8px;">
                            View Product
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No products found for "<strong><?= htmlspecialchars($query) ?></strong>".</p>
        <?php endif; ?>
    <?php endif; ?>
</section>

<?php
$content = ob_get_clean();
include "base.php";
?>