<?php
$title = "Manage Customers - 6ixe7ven";
$extra_css = "";

require_once __DIR__ . "/backend/middleware/adminOnly.php";
require_once "connection.php";
include_once "config.php";

$error = "";
$success = "";

function clean(string $v): string {
    return trim($v);
}

function isValidRole(string $role): bool {
    return in_array($role, ["customer", "admin"], true);
}

function isValidEmail(string $email): bool {
    return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";
    $currentUserId = isset($_SESSION["user_id"]) ? (int)$_SESSION["user_id"] : 0;

    if ($action === "add_user") {
        $fullName = clean($_POST["full_name"] ?? "");
        $username = clean($_POST["username"] ?? "");
        $email = clean($_POST["email"] ?? "");
        $phone = clean($_POST["phone"] ?? "");
        $address = clean($_POST["address"] ?? "");
        $role = clean($_POST["role"] ?? "customer");
        $isActive = (int)($_POST["is_active"] ?? 1);
        $forceChange = (int)($_POST["force_password_change"] ?? 1);

        $password = (string)($_POST["password"] ?? "");
        $password2 = (string)($_POST["password_confirm"] ?? "");

        $isActive = ($isActive === 1) ? 1 : 0;
        $forceChange = ($forceChange === 1) ? 1 : 0;

        if ($fullName === "" || $username === "" || $email === "") {
            $error = "Full name, username and email are required.";
        } elseif (!isValidEmail($email)) {
            $error = "Enter a valid email address.";
        } elseif (!isValidRole($role)) {
            $error = "Invalid role.";
        } elseif (strlen($password) < 6) {
            $error = "Password must be at least 6 characters.";
        } elseif ($password !== $password2) {
            $error = "Passwords do not match.";
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $conn->prepare("
                INSERT INTO users (full_name, username, email, phone, address, password, role, is_active, force_password_change)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("sssssssii", $fullName, $username, $email, $phone, $address, $hash, $role, $isActive, $forceChange);

            if ($stmt->execute()) {
                $newId = $stmt->insert_id;
                $success = "User created (ID #{$newId}).";
            } else {
                $error = "Could not create user (username/email might already exist).";
            }
            $stmt->close();
        }
    }

    $userId = (int)($_POST["user_id"] ?? 0);

    if ($action !== "add_user") {
        if ($userId <= 0) {
            $error = "Invalid user.";
        } else {

            if ($action === "toggle_active") {
                $newActive = (int)($_POST["is_active"] ?? 1);
                $newActive = ($newActive === 1) ? 1 : 0;

                if ($currentUserId === $userId && $newActive === 0) {
                    $error = "You can’t deactivate your own account while logged in.";
                } else {
                    $stmt = $conn->prepare("UPDATE users SET is_active = ? WHERE user_id = ?");
                    $stmt->bind_param("ii", $newActive, $userId);

                    if ($stmt->execute()) {
                        $success = "User updated.";
                    } else {
                        $error = "Could not update user.";
                    }
                    $stmt->close();
                }
            }

            if ($action === "set_role") {
                $role = clean($_POST["role"] ?? "");

                if (!isValidRole($role)) {
                    $error = "Invalid role.";
                } elseif ($currentUserId === $userId && $role !== "admin") {
                    $error = "You can’t remove your own admin role while logged in.";
                } else {
                    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE user_id = ?");
                    $stmt->bind_param("si", $role, $userId);

                    if ($stmt->execute()) {
                        $success = "Role updated.";
                    } else {
                        $error = "Could not update role.";
                    }
                    $stmt->close();
                }
            }

            if ($action === "update_details") {
                $fullName = clean($_POST["full_name"] ?? "");
                $email = clean($_POST["email"] ?? "");
                $username = clean($_POST["username"] ?? "");
                $phone = clean($_POST["phone"] ?? "");
                $address = clean($_POST["address"] ?? "");

                if ($fullName === "" || $email === "" || $username === "") {
                    $error = "Full name, email and username are required.";
                } elseif (!isValidEmail($email)) {
                    $error = "Enter a valid email address.";
                } else {
                    $stmt = $conn->prepare("
                        UPDATE users
                        SET full_name = ?, email = ?, username = ?, phone = ?, address = ?
                        WHERE user_id = ?
                    ");
                    $stmt->bind_param("sssssi", $fullName, $email, $username, $phone, $address, $userId);

                    if ($stmt->execute()) {
                        $success = "User details updated.";
                    } else {
                        $error = "Could not update user details (email/username might already exist).";
                    }
                    $stmt->close();
                }
            }

            if ($action === "delete_user") {
                if ($currentUserId === $userId) {
                    $error = "You can’t delete your own account while logged in.";
                } else {
                    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
                    $stmt->bind_param("i", $userId);

                    if ($stmt->execute()) {
                        $success = "User deleted.";
                    } else {
                        $error = "Could not delete user (they may be linked to orders).";
                    }
                    $stmt->close();
                }
            }
        }
    }
}

$q = trim($_GET["q"] ?? "");
$roleFilter = trim($_GET["role"] ?? "");
$activeFilter = trim($_GET["active"] ?? "");

$sql = "SELECT user_id, full_name, email, username, phone, address, role, is_active, created_at FROM users";
$where = [];
$params = [];
$types = "";

if ($q !== "") {
    $where[] = "(full_name LIKE ? OR email LIKE ? OR username LIKE ?)";
    $params[] = "%{$q}%";
    $params[] = "%{$q}%";
    $params[] = "%{$q}%";
    $types .= "sss";
}

if ($roleFilter !== "" && in_array($roleFilter, ["customer", "admin"], true)) {
    $where[] = "role = ?";
    $params[] = $roleFilter;
    $types .= "s";
}

if ($activeFilter !== "" && in_array($activeFilter, ["0", "1"], true)) {
    $where[] = "is_active = ?";
    $params[] = (int)$activeFilter;
    $types .= "i";
}

if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY created_at DESC";

$users = [];
if ($params) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) $users[] = $row;
    $stmt->close();
} else {
    $res = $conn->query($sql);
    if ($res) {
        while ($row = $res->fetch_assoc()) $users[] = $row;
        $res->free();
    }
}

ob_start();
?>

<section style="padding:30px;">
    <h1>Manage Customers</h1>
    <p>View and manage user accounts (customers and admins).</p>

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

    <div style="background:#fff; border:1px solid #eee; border-radius:12px; padding:14px; margin:16px 0;">
        <h3 style="margin:0 0 10px;">Add user</h3>

        <form method="POST" action="adminCustomers.php" style="display:grid; gap:10px; max-width:720px;">
            <input type="hidden" name="action" value="add_user">

            <div style="display:grid; gap:10px; grid-template-columns:1fr 1fr;">
                <input name="full_name" placeholder="Full name" style="padding:10px;" required>
                <input name="username" placeholder="Username" style="padding:10px;" required>
            </div>

            <div style="display:grid; gap:10px; grid-template-columns:1fr 1fr;">
                <input name="email" placeholder="Email" style="padding:10px;" required>
                <input name="phone" placeholder="Phone" style="padding:10px;">
            </div>

            <input name="address" placeholder="Address" style="padding:10px;">

            <div style="display:grid; gap:10px; grid-template-columns:1fr 1fr;">
                <input type="password" name="password" placeholder="Password (min 6 chars)" style="padding:10px;" required>
                <input type="password" name="password_confirm" placeholder="Confirm password" style="padding:10px;" required>
            </div>

            <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                <label style="display:flex; gap:8px; align-items:center;">
                    Role
                    <select name="role" style="padding:10px;">
                        <option value="customer">customer</option>
                        <option value="admin">admin</option>
                    </select>
                </label>

                <label style="display:flex; gap:8px; align-items:center;">
                    Active
                    <select name="is_active" style="padding:10px;">
                        <option value="1">yes</option>
                        <option value="0">no</option>
                    </select>
                </label>

                <label style="display:flex; gap:8px; align-items:center;">
                    Force password change
                    <select name="force_password_change" style="padding:10px;">
                        <option value="1">yes</option>
                        <option value="0">no</option>
                    </select>
                </label>

                <button type="submit" style="padding:10px 14px; cursor:pointer;">Create</button>
            </div>
        </form>
    </div>

    <form method="GET" action="adminCustomers.php" style="display:flex; gap:10px; flex-wrap:wrap; margin:16px 0;">
        <input type="text" name="q" placeholder="Search name/email/username..." value="<?= htmlspecialchars($q) ?>" style="padding:10px; min-width:240px;">

        <select name="role" style="padding:10px;">
            <option value="">All roles</option>
            <option value="customer" <?= ($roleFilter === "customer") ? "selected" : "" ?>>Customer</option>
            <option value="admin" <?= ($roleFilter === "admin") ? "selected" : "" ?>>Admin</option>
        </select>

        <select name="active" style="padding:10px;">
            <option value="">Active + Inactive</option>
            <option value="1" <?= ($activeFilter === "1") ? "selected" : "" ?>>Active</option>
            <option value="0" <?= ($activeFilter === "0") ? "selected" : "" ?>>Inactive</option>
        </select>

        <button type="submit" style="padding:10px 14px; cursor:pointer;">Filter</button>
        <a href="adminCustomers.php" style="padding:10px 14px; display:inline-block;">Reset</a>
    </form>

    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; background:#fff; border-radius:10px; overflow:hidden;">
            <thead>
                <tr style="text-align:left; background:#f3f3f3;">
                    <th style="padding:12px; border-bottom:1px solid #ddd;">User</th>
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Role</th>
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Active</th>
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Created</th>
                    <th style="padding:12px; border-bottom:1px solid #ddd;">Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php if (!$users): ?>
                <tr><td colspan="5" style="padding:12px;">No users found.</td></tr>
            <?php endif; ?>

            <?php foreach ($users as $u): ?>
                <?php
                    $uid = (int)$u["user_id"];
                    $isActive = (int)$u["is_active"];
                    $role = (string)$u["role"];
                ?>
                <tr>
                    <td style="padding:12px; border-bottom:1px solid #eee;">
                        <strong><?= htmlspecialchars($u["full_name"]) ?></strong><br>
                        <small><?= htmlspecialchars($u["username"]) ?> • <?= htmlspecialchars($u["email"]) ?></small><br>
                        <small style="color:#555;">
                            <?= htmlspecialchars($u["phone"] ?? "") ?>
                            <?= ($u["address"] ?? "") !== "" ? " • " . htmlspecialchars($u["address"]) : "" ?>
                        </small>
                    </td>

                    <td style="padding:12px; border-bottom:1px solid #eee;">
                        <form method="POST" action="adminCustomers.php" style="display:flex; gap:8px; align-items:center;">
                            <input type="hidden" name="action" value="set_role">
                            <input type="hidden" name="user_id" value="<?= $uid ?>">
                            <select name="role" style="padding:8px;">
                                <option value="customer" <?= ($role === "customer") ? "selected" : "" ?>>customer</option>
                                <option value="admin" <?= ($role === "admin") ? "selected" : "" ?>>admin</option>
                            </select>
                            <button type="submit" style="padding:8px 10px; cursor:pointer;">Save</button>
                        </form>
                    </td>

                    <td style="padding:12px; border-bottom:1px solid #eee;">
                        <form method="POST" action="adminCustomers.php" style="display:flex; gap:8px; align-items:center;">
                            <input type="hidden" name="action" value="toggle_active">
                            <input type="hidden" name="user_id" value="<?= $uid ?>">
                            <input type="hidden" name="is_active" value="<?= $isActive ? 0 : 1 ?>">
                            <span style="font-weight:600;"><?= $isActive ? "Yes" : "No" ?></span>
                            <button type="submit" style="padding:8px 10px; cursor:pointer;">
                                <?= $isActive ? "Deactivate" : "Activate" ?>
                            </button>
                        </form>
                    </td>

                    <td style="padding:12px; border-bottom:1px solid #eee;">
                        <?= htmlspecialchars($u["created_at"]) ?>
                    </td>

                    <td style="padding:12px; border-bottom:1px solid #eee;">
                        <details>
                            <summary style="cursor:pointer;">Edit</summary>
                            <form method="POST" action="adminCustomers.php" style="margin-top:10px; display:grid; gap:8px;">
                                <input type="hidden" name="action" value="update_details">
                                <input type="hidden" name="user_id" value="<?= $uid ?>">

                                <input type="text" name="full_name" value="<?= htmlspecialchars($u["full_name"]) ?>" placeholder="Full name" style="padding:8px;" required>
                                <input type="text" name="username" value="<?= htmlspecialchars($u["username"]) ?>" placeholder="Username" style="padding:8px;" required>
                                <input type="email" name="email" value="<?= htmlspecialchars($u["email"]) ?>" placeholder="Email" style="padding:8px;" required>
                                <input type="text" name="phone" value="<?= htmlspecialchars($u["phone"] ?? "") ?>" placeholder="Phone" style="padding:8px;">
                                <input type="text" name="address" value="<?= htmlspecialchars($u["address"] ?? "") ?>" placeholder="Address" style="padding:8px;">

                                <button type="submit" style="padding:8px 10px; cursor:pointer;">Save details</button>
                            </form>
                        </details>

                        <form method="POST" action="adminCustomers.php" onsubmit="return confirm('Delete this user?');" style="margin-top:10px;">
                            <input type="hidden" name="action" value="delete_user">
                            <input type="hidden" name="user_id" value="<?= $uid ?>">
                            <button type="submit" style="padding:8px 10px; cursor:pointer; background:#b00020; color:#fff; border:none; border-radius:8px;">
                                Delete user
                            </button>
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