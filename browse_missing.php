<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'] ?? 'user';

// Fetch user name
$user_name_result = mysqli_query($conn,"SELECT name FROM users WHERE id='$user_id'");
$user_name_row = mysqli_fetch_assoc($user_name_result);
$user_name = $user_name_row['name'];

// Handle mark as found (admin or reporter)
if(isset($_GET['mark_found'])){
    $person_id = intval($_GET['mark_found']);

    // Check if user is admin OR the reporter
    $person_result = mysqli_query($conn,"SELECT user_id FROM missing_persons WHERE id='$person_id'");
    $person_row = mysqli_fetch_assoc($person_result);

    if($user_role=='admin' || $person_row['user_id']==$user_id){
        mysqli_query($conn,"UPDATE missing_persons SET status='found' WHERE id='$person_id'");
        $success = "Missing person marked as found.";
    } else {
        $error = "You are not authorized to mark this person as found.";
    }
}

// Fetch all missing persons with status = missing
$missing_persons = mysqli_query($conn,"SELECT mp.*, u.name AS reporter_name FROM missing_persons mp JOIN users u ON mp.user_id=u.id WHERE mp.status='missing' ORDER BY mp.created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Browse Missing Persons</title>
<style>
body{font-family: Arial;background:#f4f6f9;margin:0;}
.header{background:#2c3e50;color:white;padding:20px;text-align:center;}
.container{width:80%;margin:auto;margin-top:30px;}
.table-box{background:white;padding:20px;margin:15px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.2);}
table{width:100%;border-collapse:collapse;}
th,td{padding:10px;border-bottom:1px solid #ddd;text-align:left;}
th{background:#3498db;color:white;}
.btn{display:inline-block;padding:8px 12px;background:#3498db;color:white;text-decoration:none;border-radius:5px;}
.btn:hover{background:#2980b9;}
.notice{background:#fff3cd;padding:10px;border-radius:5px;margin-top:5px;color:#856404;}
.success{color:green;}
.error{color:red;}
</style>
</head>
<body>

<div class="header">
<h1>Browse Missing Persons</h1>
<p>See missing person details and contact information</p>
</div>

<div class="container">

<?php
if(isset($success)) echo "<p class='success'>$success</p>";
if(isset($error)) echo "<p class='error'>$error</p>";
?>

<div class="table-box">
<table>
<tr>
<th>Name</th>
<th>Age</th>
<th>Last Seen</th>
<th>Contact</th>
<th>Reporter</th>
<th>Notice</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($missing_persons)): ?>
<tr>
<td><?php echo htmlspecialchars($row['name']); ?></td>
<td><?php echo htmlspecialchars($row['age']); ?></td>
<td><?php echo htmlspecialchars($row['last_seen']); ?></td>
<td><?php echo htmlspecialchars($row['contact']); ?></td>
<td><?php echo htmlspecialchars($row['reporter_name']); ?></td>
<td class="notice">If found, contact police or authorities</td>
<td>
<?php
// Show “Mark as Found” button only for admin or reporter
if($user_role=='admin' || $row['user_id']==$user_id):
?>
<a class="btn" href="browse_missing.php?mark_found=<?php echo $row['id']; ?>">Mark as Found</a>
<?php endif; ?>
</td>
</tr>
<?php endwhile; ?>
</table>
</div>

</div>
</body>
</html>