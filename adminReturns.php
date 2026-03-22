<?php
$title = "Admin - Returns - 6ixe7ven";
$extra_css = "";

require_once __DIR__ . "/backend/middleware/adminOnly.php";
require_once "connection.php";
include_once "config.php";

$error = "";
$success = "";

$allowedStatuses = ["requested", "approved", "rejected", "received", "refunded"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $returnId = (int)($_POST["return_id"] ?? 0);
    $newStatus = trim($_POST["status"] ?? "");

    if ($returnId <= 0 || !in_array($newStatus, $allowedStatuses, true)) {
        $error = "Invalid update.";
    } else {
        $stmt = $conn->prepare("SELECT product_id, qty, status FROM returns WHERE return_id = ? LIMIT 1");
        $stmt->bind_param("i", $returnId);
        $stmt->execute();
        $r = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$r) {
            $error = "Return not found.";
        } else {
            $oldStatus = (string)$r["status"];
            $productId = (int)$r["product_id"];
            $qty = (int)$r["qty"];

            $stmt = $conn->prepare("UPDATE returns SET status = ? WHERE return_id = ?");
            $stmt->bind_param("si", $newStatus, $returnId);

            if ($stmt->execute()) {
                $success = "Return updated.";

                if ($newStatus === "received" && $oldStatus !== "received") {
                    $st2 = $conn->prepare("UPDATE products SET stock = stock + ? WHERE product_id = ?");
                    $st2->bind_param("ii", $qty, $productId);
                    $st2->execute();
                    $st2->close();
                }
            } else {
                $error = "Could not update return.";
            }
            $stmt->close();
        }
    }
}

$statusFilter = trim($_GET["status"] ?? "");
$q = trim($_GET["q"] ?? "");

$sql = "
    SELECT r.return_id, r.order_id, r.product_id, r.user_id, r.qty, r.reason, r.status, r.created_at,
           u.username, u.email,
           p.name AS product_name
    FROM returns r
    LEFT JOIN users u ON u.user_id = r.user_id
    LEFT JOIN products p ON p.product_id = r.product_id
";

$where = [];
$params = [];
$types = "";

if ($statusFilter !== "" && in_array($statusFilter, $allowedStatuses, true)) {
    $where[] = "r.status = ?";
    $params[] = $statusFilter;
    $types .= "s";
}

if ($q !== "") {
    $where[] = "(u.username LIKE ? OR u.email LIKE ? OR p.name LIKE ? OR r.reason LIKE ?)";
    $like = "%{$q}%";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $types .= "ssss";
}

if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY r.created_at DESC";

$rows = [];
if ($params) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) $rows[] = $row;
    $stmt->close();
} else {
    $res = $conn->query($sql);
    if ($res) {
        while ($row = $res->fetch_assoc()) $rows[] = $row;
        $res->free();
    }
}

ob_start();
?>

<section style="padding:30px;">
    <h1>Returns</h1>
    <p>Review return requests and update status. Marking a return as <strong>received</strong> will restock the product.</p>

    <div style="margin:12px 0;">
        <a href="admin.php">← Back to Admin</a>
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

    <form method="GET" action="adminReturns.php" style="display:flex; gap:10px; flex-wrap:wrap; margin:16px 0;">
        <input type="text" name="q" placeholder="Search user/product/reason..." value="<?= htmlspecialchars($q) ?>" style="padding:10px; min-width:260px;">

        <select name="status" style="padding:10px;">
            <option value="">All statuses</option>
            <?php foreach ($allowedStatuses as $s): ?>
                <option value="<?= $s ?>" <?= ($statusFilter === $s) ? "selected" : "" ?>><?= $s ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" style="padding:10px 14px; cursor:pointer;">Filter</button>
        <a href="adminReturns.php" style="padding:10px 14px; display:inline-block;">Reset</a>
    </form>

    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; background:#fff; border-radius:10px; overflow:hidden;">
            <thead>
                <tr style="text-align:left; background:#f3f3f3;">
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Return</th>
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Customer</th>
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Product</th>
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Qty</th>
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Reason</th>
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Status</th>
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Update</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$rows): ?>
                    <tr><td colspan="7" style="padding:12px;">No returns found.</td></tr>
                <?php endif; ?>

                <?php foreach ($rows as $r): ?>
                    <tr>
                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            #<?= (int)$r["return_id"] ?><br>
                            <small>Order #<?= (int)$r["order_id"] ?> • <?= htmlspecialchars($r["created_at"]) ?></small>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <strong><?= htmlspecialchars($r["username"] ?? "—") ?></strong><br>
                            <small><?= htmlspecialchars($r["email"] ?? "") ?></small>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <?= htmlspecialchars($r["product_name"] ?? "—") ?><br>
                            <small>ID: <?= (int)$r["product_id"] ?></small>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <?= (int)$r["qty"] ?>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <?= htmlspecialchars($r["reason"]) ?>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <strong><?= htmlspecialchars($r["status"]) ?></strong>
                        </td>

                        <td style="padding:12px; border-bottom:1px solid #eee;">
                            <form method="POST" action="adminReturns.php" style="display:flex; gap:8px; align-items:center;">
                                <input type="hidden" name="return_id" value="<?= (int)$r["return_id"] ?>">
                                <select name="status" style="padding:8px;">
                                    <?php foreach ($allowedStatuses as $s): ?>
                                        <option value="<?= $s ?>" <?= ($r["status"] === $s) ? "selected" : "" ?>>
                                            <?= $s ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" style="padding:8px 10px; cursor:pointer;">Save</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php
$content = ob_get_clean();
include "base.php";
?>