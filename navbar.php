<nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="browse_items.php">Browse Items</a>
    <a href="report_lost.php">Report Lost</a>
    <a href="report_found.php">Report Found</a>
    <a href="report_missing.php">Report Missing</a>
    <a href="logout.php">Logout</a>
    <?php if($_SESSION['role'] ?? ''=='admin'){ ?>
        <a href="admin_dashboard.php">Admin Panel</a>
    <?php } ?>
</nav>