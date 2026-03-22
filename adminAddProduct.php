<?php
$title = "Add Product - 6ixe7ven";
$extra_css = "";

require_once __DIR__ . "/backend/middleware/adminOnly.php";
require_once "connection.php";
include_once "config.php";

if (!isset($BASE_URL) || !is_string($BASE_URL)) {
    $BASE_URL = "";
}

$error = "";
$success = "";

// When submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $priceRaw = trim($_POST["price"] ?? "");
    $image = trim($_POST["image"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $stockRaw = trim($_POST["stock"] ?? "0");

    if ($name === "" || $image === "" || $priceRaw === "" || !is_numeric($priceRaw) || (float)$priceRaw < 0) {
        $error = "Name, image, and a valid price are required.";
    } elseif ($stockRaw === "" || !is_numeric($stockRaw) || (int)$stockRaw < 0) {
        $error = "Stock must be 0 or higher.";
    } else {
        $price = (float)$priceRaw;
        $stock = (int)$stockRaw;

        $stmt = $conn->prepare("
            INSERT INTO products (name, price, image, description, category, stock)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sdsssi", $name, $price, $image, $description, $category, $stock);

        if ($stmt->execute()) {
            $newId = $stmt->insert_id;
            $success = "Product created (ID #{$newId}).";
        } else {
            $error = "Could not create product.";
        }
        $stmt->close();
    }
}

ob_start();
?>

<section style="padding:30px;">
    <h1>Add Product</h1>
    <p>Create a new product in the inventory.</p>

    <div style="margin: 12px 0; display:flex; gap:10px; flex-wrap:wrap;">
        <a href="adminInventory.php">← Back to Inventory</a>
    </div>

    <?php if ($error !== ""): ?>
        <div style="background:#ffe5e5; padding:10px; border-radius:8px; margin:12px 0;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($success !== ""): ?>
        <div style="background:#e7ffe5; padding:10px; border-radius:8px; margin:12px 0;">
            <?= htmlspecialchars($success) ?>
            <div style="margin-top:8px;">
                <a href="adminInventory.php">Go to Inventory</a>
            </div>
        </div>
    <?php endif; ?>

    <form method="POST" action="adminAddProduct.php" style="max-width:650px; display:grid; gap:12px; margin-top:16px;">
        <label>
            Product Name
            <input type="text" name="name" required style="width:100%; padding:10px;">
        </label>

        <label>
            Price (£)
            <input type="text" name="price" required style="width:100%; padding:10px;">
        </label>

        <label>
            Image path or URL
            <input type="text" name="image" required placeholder="e.g. images/hoodie2.jpeg" style="width:100%; padding:10px;">
            <small style="color:#555;">Tip: use the same format as the rest of your DB (usually <b>images/filename.jpeg</b>).</small>
        </label>

        <label>
            Category
            <input type="text" name="category" placeholder="e.g. Hoodies" style="width:100%; padding:10px;">
        </label>

        <label>
            Stock
            <input type="number" name="stock" min="0" value="0" style="width:100%; padding:10px;">
        </label>

        <label>
            Description
            <textarea name="description" style="width:100%; padding:10px; min-height:110px;"></textarea>
        </label>

        <button type="submit" style="padding:12px 14px; background:#111; color:#fff; border:none; border-radius:10px; cursor:pointer;">
            Create Product
        </button>
    </form>
</section>

<?php
$content = ob_get_clean();
include "base.php";
?>
