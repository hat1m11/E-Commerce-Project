<?php
$title = "Admin Orders - 6ixe7ven";
$extra_css = "";

require_once __DIR__ . "/backend/middleware/adminOnly.php";
require_once "connection.php";

$error = "";
$success = "";

function pickCol(array $availableCols, array $candidates) {
    foreach ($candidates as $c) {
        if (in_array($c, $availableCols, true)) return $c;
    }
    return null;
}

function getTableCols(mysqli $conn, string $table): array {
    $cols = [];
    $res = $conn->query("SHOW COLUMNS FROM `$table`");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $cols[] = $row['Field'];
        }
        $res->free();
    }
    return $cols;
}

$orderItemsCols = getTableCols($conn, "order_items");
$productsCols   = getTableCols($conn, "products");

$orderIdCol_oi   = pickCol($orderItemsCols, ['order_id', 'orderId']);
$productIdCol_oi = pickCol($orderItemsCols, ['product_id', 'productId', 'prod_id', 'item_id']);
$qtyCol_oi       = pickCol($orderItemsCols, ['quantity', 'qty', 'amount']);
$priceCol_oi     = pickCol($orderItemsCols, ['price', 'unit_price', 'unitPrice', 'item_price']);
$subtotalCol_oi  = pickCol($orderItemsCols, ['subtotal', 'line_total', 'lineTotal', 'total']);

$productIdCol_p  = pickCol($productsCols, ['product_id', 'productId', 'id']);
$nameCol_p       = pickCol($productsCols, ['name', 'product_name', 'title']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $orderId = (int)$_POST['order_id'];
    $status  = trim($_POST['status']);

    $allowed = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

    if (!in_array($status, $allowed, true)) {
        $error = "Invalid status.";
    } else {
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
        if ($stmt) {
            $stmt->bind_param("si", $status, $orderId);
            if ($stmt->execute()) {
                $success = "Order #{$orderId} updated to '{$status}'.";
            } else {
                $error = "Failed to update order. Try again.";
            }
            $stmt->close();
        } else {
            $error = "Server error: could not prepare statement.";
        }
    }
}

$result = $conn->query("
    SELECT order_id, user_id, total, status, created_at
    FROM orders
    ORDER BY created_at DESC
");

$itemStmt = null;
$canShowItems = ($orderIdCol_oi !== null);

if ($canShowItems) {
    if ($productIdCol_oi && $productIdCol_p && $nameCol_p) {
        $sqlItems = "
            SELECT oi.*,
                   p.`$nameCol_p` AS product_name
            FROM order_items oi
            LEFT JOIN products p
              ON oi.`$productIdCol_oi` = p.`$productIdCol_p`
            WHERE oi.`$orderIdCol_oi` = ?
        ";
    } else {
        $sqlItems = "SELECT * FROM order_items WHERE `$orderIdCol_oi` = ?";
    }

    $itemStmt = $conn->prepare($sqlItems);
    if (!$itemStmt) {
        $canShowItems = false;
    }
}

ob_start();
?>

<section style="padding: 30px;">
  <h1>Admin - Process Orders</h1>
  <p>Update order statuses and view order items.</p>

  <div style="margin: 12px 0;">
    <a href="admin.php">← Back to Admin</a>
  </div>

  <?php if (!empty($error)): ?>
    <div style="background:#ffe5e5; padding:10px; border-radius:8px; margin:12px 0;">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($success)): ?>
    <div style="background:#e7ffe5; padding:10px; border-radius:8px; margin:12px 0;">
      <?= htmlspecialchars($success) ?>
    </div>
  <?php endif; ?>

  <?php if (!$canShowItems): ?>
    <div style="background:#fff3cd; padding:10px; border-radius:8px; margin:12px 0;">
      Note: Could not auto-detect your <strong>order_items</strong> structure, so items may not display.
      If this happens, paste your <strong>order_items</strong> table columns and I’ll wire it perfectly.
    </div>
  <?php endif; ?>

  <div style="overflow-x:auto; margin-top:16px;">
    <table style="width:100%; border-collapse:collapse; background:#fff; border-radius:10px; overflow:hidden;">
      <thead>
        <tr style="text-align:left; background:#f3f3f3;">
          <th style="padding:12px; border-bottom:1px solid #ddd;">Order #</th>
          <th style="padding:12px; border-bottom:1px solid #ddd;">User ID</th>
          <th style="padding:12px; border-bottom:1px solid #ddd;">Total</th>
          <th style="padding:12px; border-bottom:1px solid #ddd;">Created</th>
          <th style="padding:12px; border-bottom:1px solid #ddd;">Status</th>
          <th style="padding:12px; border-bottom:1px solid #ddd;">Update</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <?php $oid = (int)$row['order_id']; ?>
            <tr>
              <td style="padding:12px; border-bottom:1px solid #eee;">
                <strong>#<?= $oid ?></strong>

                <?php if ($canShowItems): ?>
                  <details style="margin-top:8px;">
                    <summary style="cursor:pointer;">View items</summary>

                    <div style="margin-top:10px;">
                      <?php
                      $items = [];
                      $itemStmt->bind_param("i", $oid);
                      $itemStmt->execute();
                      $itemsRes = $itemStmt->get_result();
                      if ($itemsRes) {
                          while ($it = $itemsRes->fetch_assoc()) $items[] = $it;
                      }
                      ?>

                      <?php if (count($items) === 0): ?>
                        <p style="margin:0;">No items found for this order.</p>
                      <?php else: ?>
                        <table style="width:100%; border-collapse:collapse; margin-top:8px;">
                          <thead>
                            <tr style="text-align:left;">
                              <th style="padding:8px; border-bottom:1px solid #ddd;">Product</th>
                              <th style="padding:8px; border-bottom:1px solid #ddd;">Qty</th>
                              <th style="padding:8px; border-bottom:1px solid #ddd;">Price</th>
                              <th style="padding:8px; border-bottom:1px solid #ddd;">Subtotal</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($items as $it): ?>
                              <?php
                                $pname = $it['product_name'] ?? null;
                                $pid = $productIdCol_oi ? ($it[$productIdCol_oi] ?? null) : null;

                                $qty = $qtyCol_oi ? ($it[$qtyCol_oi] ?? null) : null;
                                $price = $priceCol_oi ? ($it[$priceCol_oi] ?? null) : null;
                                $sub = $subtotalCol_oi ? ($it[$subtotalCol_oi] ?? null) : null;

                                $qtyNum = ($qty !== null && is_numeric($qty)) ? (float)$qty : null;
                                $priceNum = ($price !== null && is_numeric($price)) ? (float)$price : null;

                                $subCalculated = null;
                                if ($sub !== null && is_numeric($sub)) {
                                    $subCalculated = (float)$sub;
                                } elseif ($qtyNum !== null && $priceNum !== null) {
                                    $subCalculated = $qtyNum * $priceNum;
                                }
                              ?>
                              <tr>
                                <td style="padding:8px; border-bottom:1px solid #eee;">
                                  <?= htmlspecialchars($pname ?: ("Product ID: " . ($pid ?? "N/A"))) ?>
                                </td>
                                <td style="padding:8px; border-bottom:1px solid #eee;">
                                  <?= htmlspecialchars($qty ?? "—") ?>
                                </td>
                                <td style="padding:8px; border-bottom:1px solid #eee;">
                                  <?= $price !== null ? "£" . htmlspecialchars($price) : "—" ?>
                                </td>
                                <td style="padding:8px; border-bottom:1px solid #eee;">
                                  <?= $subCalculated !== null ? "£" . htmlspecialchars(number_format($subCalculated, 2)) : "—" ?>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      <?php endif; ?>
                    </div>
                  </details>
                <?php endif; ?>
              </td>

              <td style="padding:12px; border-bottom:1px solid #eee;"><?= (int)$row['user_id'] ?></td>
              <td style="padding:12px; border-bottom:1px solid #eee;">£<?= htmlspecialchars($row['total']) ?></td>
              <td style="padding:12px; border-bottom:1px solid #eee;"><?= htmlspecialchars($row['created_at']) ?></td>
              <td style="padding:12px; border-bottom:1px solid #eee;"><strong><?= htmlspecialchars($row['status']) ?></strong></td>

              <td style="padding:12px; border-bottom:1px solid #eee;">
                <form method="POST" action="adminOrders.php" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                  <input type="hidden" name="order_id" value="<?= $oid ?>">

                  <select name="status" required style="padding:8px;">
                    <?php
                      $current = $row['status'];
                      $options = ['pending','processing','shipped','delivered','cancelled'];
                      foreach ($options as $opt) {
                        $sel = ($opt === $current) ? "selected" : "";
                        echo "<option value=\"" . htmlspecialchars($opt) . "\" $sel>" . htmlspecialchars($opt) . "</option>";
                      }
                    ?>
                  </select>

                  <button type="submit" style="padding:8px 12px; cursor:pointer;">Save</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="6" style="padding:12px;">No orders found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</section>

<?php
$content = ob_get_clean();
include "base.php";

if ($itemStmt) $itemStmt->close();
?>