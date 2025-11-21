<?php
session_start();

// ADMIN PROTECTION
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

$title = "Users";

// PAGE-SPECIFIC CSS
$extra_css = '<link rel="stylesheet" href="../static/css/admin/adminUsers.css">';

ob_start();
?>

<div class="content-header">
    <h1 class="page-title">Users</h1>
    <p class="page-subtitle">View and manage registered users</p>
</div>

<div class="admin-table-container">

    <div class="table-header">
        <h2 class="table-title">User List</h2>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

            <!-- SAMPLE DATA (replace with DB data later) -->

            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>john@example.com</td>
                <td><span class="role role-user">User</span></td>
                <td><span class="user-status active">Active</span></td>
                <td>2025-01-15</td>
                <td>
                    <a href="view_user.php?id=1" class="btn btn-secondary">View</a>
                    <a href="edit_user.php?id=1" class="btn btn-primary">Edit</a>
                    <a href="delete_user.php?id=1" class="btn btn-danger">Delete</a>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td>Mary Smith</td>
                <td>mary@example.com</td>
                <td><span class="role role-admin">Admin</span></td>
                <td><span class="user-status banned">Banned</span></td>
                <td>2025-01-10</td>
                <td>
                    <a href="view_user.php?id=2" class="btn btn-secondary">View</a>
                    <a href="edit_user.php?id=2" class="btn btn-primary">Edit</a>
                    <a href="delete_user.php?id=2" class="btn btn-danger">Delete</a>
                </td>
            </tr>

            <tr>
                <td>3</td>
                <td>Ali Khan</td>
                <td>ali@example.com</td>
                <td><span class="role role-user">User</span></td>
                <td><span class="user-status active">Active</span></td>
                <td>2025-01-05</td>
                <td>
                    <a href="view_user.php?id=3" class="btn btn-secondary">View</a>
                    <a href="edit_user.php?id=3" class="btn btn-primary">Edit</a>
                    <a href="delete_user.php?id=3" class="btn btn-danger">Delete</a>
                </td>
            </tr>

        </tbody>

    </table>

</div>

<?php
$content = ob_get_clean();
include "adminBase.php";
?>
