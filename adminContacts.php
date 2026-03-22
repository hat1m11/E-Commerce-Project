<?php
$title = "Admin - Contact Inbox - 6ixe7ven";
$extra_css = "";

require_once __DIR__ . "/backend/middleware/adminOnly.php";
require_once "connection.php";
include_once "config.php";

$error = "";
$success = "";

$allowedStatuses = ["new", "seen", "closed"];

// Update status / delete
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";
    $contactId = (int)($_POST["contact_id"] ?? 0);

    if ($contactId <= 0) {
        $error = "Invalid message.";
    } else {
        if ($action === "set_status") {
            $status = trim($_POST["status"] ?? "");
            if (!in_array($status, $allowedStatuses, true)) {
                $error = "Invalid status.";
            } else {
                $stmt = $conn->prepare("UPDATE contact_requests SET status = ? WHERE contact_id = ?");
                $stmt->bind_param("si", $status, $contactId);

                if ($stmt->execute()) {
                    $success = "Message updated.";
                } else {
                    $error = "Could not update message.";
                }
                $stmt->close();
            }
        }

        if ($action === "delete") {
            $stmt = $conn->prepare("DELETE FROM contact_requests WHERE contact_id = ?");
            $stmt->bind_param("i", $contactId);

            if ($stmt->execute()) {
                $success = "Message deleted.";
            } else {
                $error = "Could not delete message.";
            }
            $stmt->close();
        }
    }
}

// Filters
$statusFilter = trim($_GET["status"] ?? "");
$q = trim($_GET["q"] ?? "");

// Fetch messages
$sql = "SELECT contact_id, name, email, subject, message, status, created_at FROM contact_requests";
$where = [];
$params = [];
$types = "";

if ($statusFilter !== "" && in_array($statusFilter, $allowedStatuses, true)) {
    $where[] = "status = ?";
    $params[] = $statusFilter;
    $types .= "s";
}

if ($q !== "") {
    $where[] = "(name LIKE ? OR email LIKE ? OR subject LIKE ? OR message LIKE ?)";
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

$sql .= " ORDER BY created_at DESC";

$messages = [];
if ($params) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) $messages[] = $row;
    $stmt->close();
} else {
    $res = $conn->query($sql);
    if ($res) {
        while ($row = $res->fetch_assoc()) $messages[] = $row;
        $res->free();
    }
}

ob_start();
?>

<section style="padding:30px;">
    <h1>Contact Inbox</h1>
    <p>Messages sent through the contact form.</p>

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

    <form method="GET" action="adminContacts.php" style="display:flex; gap:10px; flex-wrap:wrap; margin:16px 0;">
        <input type="text" name="q" placeholder="Search name/email/subject/message..." value="<?= htmlspecialchars($q) ?>" style="padding:10px; min-width:260px;">

        <select name="status" style="padding:10px;">
            <option value="">All statuses</option>
            <option value="new" <?= ($statusFilter === "new") ? "selected" : "" ?>>new</option>
            <option value="seen" <?= ($statusFilter === "seen") ? "selected" : "" ?>>seen</option>
            <option value="closed" <?= ($statusFilter === "closed") ? "selected" : "" ?>>closed</option>
        </select>

        <button type="submit" style="padding:10px 14px; cursor:pointer;">Filter</button>
        <a href="adminContacts.php" style="padding:10px 14px; display:inline-block;">Reset</a>
    </form>

    <?php if (!$messages): ?>
        <div style="margin-top:14px;">No messages found.</div>
    <?php else: ?>
        <div style="display:grid; gap:12px; margin-top:14px;">
            <?php foreach ($messages as $m): ?>
                <?php
                    $cid = (int)$m["contact_id"];
                    $status = (string)$m["status"];
                ?>
                <div style="background:#fff; border:1px solid #eee; border-radius:12px; padding:14px;">
                    <div style="display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap;">
                        <div>
                            <strong><?= htmlspecialchars($m["subject"]) ?></strong><br>
                            <small>
                                From: <?= htmlspecialchars($m["name"]) ?> (<?= htmlspecialchars($m["email"]) ?>)
                                • <?= htmlspecialchars($m["created_at"]) ?>
                            </small>
                        </div>
                        <div style="display:flex; gap:8px; align-items:center;">
                            <span style="padding:4px 10px; border-radius:999px; background:#f2f2f2;">
                                <?= htmlspecialchars($status) ?>
                            </span>
                        </div>
                    </div>

                    <div style="margin-top:10px; white-space:pre-wrap; color:#333;">
                        <?= htmlspecialchars($m["message"]) ?>
                    </div>

                    <div style="margin-top:12px; display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                        <form method="POST" action="adminContacts.php" style="display:flex; gap:8px; align-items:center;">
                            <input type="hidden" name="action" value="set_status">
                            <input type="hidden" name="contact_id" value="<?= $cid ?>">
                            <select name="status" style="padding:8px;">
                                <option value="new" <?= ($status === "new") ? "selected" : "" ?>>new</option>
                                <option value="seen" <?= ($status === "seen") ? "selected" : "" ?>>seen</option>
                                <option value="closed" <?= ($status === "closed") ? "selected" : "" ?>>closed</option>
                            </select>
                            <button type="submit" style="padding:8px 10px; cursor:pointer;">Save</button>
                        </form>

                        <a href="mailto:<?= htmlspecialchars($m["email"]) ?>?subject=<?= rawurlencode("Re: " . $m["subject"]) ?>"
                           style="padding:8px 10px; text-decoration:none; border:1px solid #ddd; border-radius:8px;">
                            Reply (email)
                        </a>

                        <form method="POST" action="adminContacts.php" onsubmit="return confirm('Delete this message?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="contact_id" value="<?= $cid ?>">
                            <button type="submit" style="padding:8px 10px; cursor:pointer; background:#b00020; color:#fff; border:none; border-radius:8px;">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php
$content = ob_get_clean();
include "base.php";
?>
