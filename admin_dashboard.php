<?php
session_start();
include "db.php";

// Check if admin is logged in
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

// Fetch notifications
$notifications_result = mysqli_query($conn, "SELECT * FROM notifications ORDER BY created_at DESC");

// Fetch lost items
$lost_result = mysqli_query($conn, "SELECT lost_items.*, users.name AS user_name 
                                    FROM lost_items 
                                    JOIN users ON lost_items.user_id = users.id
                                    ORDER BY created_at DESC");

// Fetch found items
$found_result = mysqli_query($conn, "SELECT found_items.*, users.name AS user_name 
                                     FROM found_items 
                                     JOIN users ON found_items.user_id = users.id
                                     ORDER BY created_at DESC");

// Fetch missing persons
$missing_result = mysqli_query($conn, "SELECT missing_persons.*, users.name AS reporter_name 
                                       FROM missing_persons 
                                       JOIN users ON missing_persons.user_id = users.id
                                       ORDER BY created_at DESC");

// Optional: delete item/report if requested
if(isset($_GET['delete_lost'])){
    $id = intval($_GET['delete_lost']);
    mysqli_query($conn, "DELETE FROM lost_items WHERE id='$id'");
    header("Location: admin_dashboard.php");
}
if(isset($_GET['delete_found'])){
    $id = intval($_GET['delete_found']);
    mysqli_query($conn, "DELETE FROM found_items WHERE id='$id'");
    header("Location: admin_dashboard.php");
}
if(isset($_GET['delete_missing'])){
    $id = intval($_GET['delete_missing']);
    mysqli_query($conn, "DELETE FROM missing_persons WHERE id='$id'");
    header("Location: admin_dashboard.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard | FindIt</title>
<style>
body { font-family: Arial; background:#f5f5f5; margin:0; padding:0; }
.container { max-width:1200px; margin:20px auto; padding:20px; background:#fff; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
h1 { text-align:center; color:#333; margin-bottom:20px; }
section { margin-bottom:40px; }
h2 { color:#007bff; margin-bottom:10px; }
table { width:100%; border-collapse:collapse; margin-top:10px; }
th, td { border:1px solid #ccc; padding:8px; text-align:left; }
th { background:#007bff; color:#fff; }
td img { width:100px; height:70px; object-fit:cover; border-radius:5px; }
a.delete { color:red; text-decoration:none; font-weight:bold; }
.notifications { background:#f9f9f9; padding:10px; border-radius:8px; max-height:200px; overflow-y:auto; }
.notifications p { margin:5px 0; font-size:14px; }
@media(max-width:768px){
    table, th, td { font-size:12px; }
    td img { width:70px; height:50px; }
}
</style>
</head>
<body>
<div class="container">
    <h1>Admin Dashboard</h1>

    <!-- Notifications -->
    <section>
        <h2>Notifications</h2>
        <div class="notifications">
        <?php
        if(mysqli_num_rows($notifications_result) > 0){
            while($row = mysqli_fetch_assoc($notifications_result)){
                echo "<p>".htmlspecialchars($row['message'])." <small>(".$row['created_at'].")</small></p>";
            }
        } else {
            echo "<p>No notifications yet.</p>";
        }
        ?>
        </div>
    </section>

    <!-- Lost Items -->
    <section>
        <h2>Lost Items</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Title</th>
                <th>Category</th>
                <th>Description</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($lost_result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><img src="uploads/<?php echo $row['image']; ?>" alt=""></td>
                <td><?php echo $row['created_at']; ?></td>
                <td><a class="delete" href="?delete_lost=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a></td>
            </tr>
            <?php } ?>
        </table>
    </section>

    <!-- Found Items -->
    <section>
        <h2>Found Items</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Title</th>
                <th>Category</th>
                <th>Description</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($found_result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><img src="uploads/<?php echo $row['image']; ?>" alt=""></td>
                <td><?php echo $row['created_at']; ?></td>
                <td><a class="delete" href="?delete_found=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a></td>
            </tr>
            <?php } ?>
        </table>
    </section>

    <!-- Missing Persons -->
    <section>
        <h2>Missing Persons</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Reporter</th>
                <th>Name</th>
                <th>Age</th>
                <th>Last Seen</th>
                <th>Contact</th>
                <th>Image</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($missing_result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['reporter_name']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo $row['age']; ?></td>
                <td><?php echo htmlspecialchars($row['last_seen']); ?></td>
                <td><?php echo htmlspecialchars($row['contact']); ?></td>
                <td><img src="uploads/<?php echo $row['image']; ?>" alt=""></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td><a class="delete" href="?delete_missing=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a></td>
            </tr>
            <?php } ?>
        </table>
    </section>

</div>
</body>
</html>