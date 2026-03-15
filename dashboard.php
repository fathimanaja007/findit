<?php
session_start();
include "db.php";

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$result = mysqli_query($conn,"SELECT name, role FROM users WHERE id='$user_id'");
$row = mysqli_fetch_assoc($result);
$user_name = $row['name'];
$user_role = $row['role'];

// --- Updated Notifications Query ---
// Users see notifications addressed to them or admin messages
$notifications_query = "SELECT * FROM notifications WHERE user_id='$user_id' OR user_id=1 ORDER BY created_at DESC LIMIT 5";
$notifications = mysqli_query($conn,$notifications_query);
?>

<!DOCTYPE html>
<html>
<head>
<title>FindIt Dashboard</title>
<style>
body{font-family: Arial;background:#f4f6f9;margin:0;}
.header{background:#2c3e50;color:white;padding:20px;text-align:center;}
.container{width:80%;margin:auto;margin-top:30px;}
.card{background:white;padding:20px;margin:15px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.2);}
.btn{display:block;padding:15px;margin:10px 0;background:#3498db;color:white;text-decoration:none;border-radius:5px;text-align:center;}
.btn:hover{background:#2980b9;}
.notifications{background:#fff3cd;padding:15px;border-radius:5px;margin-bottom:20px;}
</style>
</head>
<body>

<div class="header">
<h1>FindIt Dashboard</h1>
<p>Helping communities find what's missing</p>
</div>

<div class="container">

<div class="notifications">
<h3>Notifications</h3>
<?php 
while($row = mysqli_fetch_assoc($notifications)){
    echo "<p>".htmlspecialchars($row['message'])."</p>";
} 
?>
</div>

<div class="card">
<a class="btn" href="report_lost.php">Report Lost Item</a>
<a class="btn" href="report_found.php">Report Found Item</a>
<a class="btn" href="browse_items.php">Browse Items</a>
<a class="btn" href="report_missing.php">Report Missing Person</a>
<a class="btn" href="browse_missing.php">Browse Missing Persons</a>

<?php if($user_role=='admin'): ?>
<a class="btn" href="admin_dashboard.php">Admin Panel</a>
<?php endif; ?>
</div>

</div>
</body>
</html>