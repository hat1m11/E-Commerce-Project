<?php
session_start();

// ADMIN PROTECTION
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

$title = "Orders";

// PAGE-SPECIFIC CSS
$extra_css = '<link rel="stylesheet" href="../static/css/admin/adminOrders.css">';

ob_start();
?>

<div class="content-header">
    <h1 class="page-title">Orders</h1>
    <p class="page-subtitle">View and manage customer orders</p>
</div>

<div class="admin-table-container">

    <div class="table-header">
        <h2 class="table-title">Order List</h2>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Total (£)</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

            <!-- SAMPLE DATA – replace later with database -->
            <tr>
                <td>#1024</td>
                <td>John Doe</td>
                <td>£145.00</td>
                <td><span class="status status-pending">Pending</span></td>
                <td>2025-01-20</td>
                <td>
                    <a href="view_order.php?id=1024" class="btn btn-secondary">View</a>
                    <a href="edit_order.php?id=1024" class="btn btn-primary">Update</a>
                    <a href="delete_order.php?id=1024" class="btn btn-danger">Delete</a>
                </td>
            </tr>

            <tr>
                <td>#1023</td>
                <td>Mary Ann</td>
                <td>£89.99</td>
                <td><span class="status status-shipped">Shipped</span></td>
                <td>2025-01-19</td>
                <td>
                    <a href="view_order.php?id=1023" class="btn btn-secondary">View</a>
                    <a href="edit_order.php?id=1023" class="btn btn-primary">Update</a>
                    <a href="delete_order.php?id=1023" class="btn btn-danger">Delete</a>
                </td>
            </tr>

            <tr>
                <td>#1022</td>
                <td>Ali Khan</td>
                <td>£210.00</td>
                <td><span class="status status-delivered">Delivered</span></td>
                <td>2025-01-18</td>
                <td>
                    <a href="view_order.php?id=1022" class="btn btn-secondary">View</a>
                    <a href="edit_order.php?id=1022" class="btn btn-primary">Update</a>
                    <a href="delete_order.php?id=1022" class="btn btn-danger">Delete</a>
                </td>
            </tr>

            <tr>
                <td>#1021</td>
                <td>Sara White</td>
                <td>£72.50</td>
                <td><span class="status status-cancelled">Cancelled</span></td>
                <td>2025-01-17</td>
                <td>
                    <a href="view_order.php?id=1021" class="btn btn-secondary">View</a>
                    <a href="edit_order.php?id=1021" class="btn btn-primary">Update</a>
                    <a href="delete_order.php?id=1021" class="btn btn-danger">Delete</a>
                </td>
            </tr>

        </tbody>
    </table>

</div>

<?php
$content = ob_get_clean();
include "adminBase.php";
?>
