<?php
session_start();

// ADMIN PROTECTION
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

$title = "Settings";

// PAGE-SPECIFIC CSS
$extra_css = '<link rel="stylesheet" href="../static/css/admin/adminSettings.css">';

ob_start();
?>

<div class="content-header">
    <h1 class="page-title">Settings</h1>
    <p class="page-subtitle">Manage store settings and configurations</p>
</div>

<div class="settings-container">

    <form class="settings-form">

        <h2 class="section-title">General Settings</h2>

        <label class="settings-label">Store Name</label>
        <input type="text" class="settings-input" value="6ixe7ven">

        <label class="settings-label">Support Email</label>
        <input type="email" class="settings-input" value="support@6ixe7ven.com">

        <label class="settings-label">Support Phone</label>
        <input type="text" class="settings-input" value="+44 7123 456789">

        <hr class="divider">

        <h2 class="section-title">Homepage Controls</h2>

        <div class="toggle-row">
            <span>Enable Banner Rotation</span>
            <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
            </label>
        </div>

        <div class="toggle-row">
            <span>Show Featured Products</span>
            <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
            </label>
        </div>

        <hr class="divider">

        <h2 class="section-title">System Settings</h2>

        <div class="toggle-row">
            <span>Maintenance Mode</span>
            <label class="switch">
                <input type="checkbox">
                <span class="slider"></span>
            </label>
        </div>

        <button class="btn btn-primary save-btn" type="submit">Save Changes</button>

    </form>

</div>

<?php
$content = ob_get_clean();
include "adminBase.php";
?>
