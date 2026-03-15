<?php
// Start session safely
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "db.php"; // Your database connection

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

if(isset($_POST['submit'])){
    $user_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Handle image upload
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $upload_dir = "uploads/";
    move_uploaded_file($tmp_name, $upload_dir.$image);

    // Insert lost item
    mysqli_query($conn, "INSERT INTO lost_items (user_id, title, category, description, image) VALUES ('$user_id', '$title', '$category', '$description', '$image')");
    $success = "Lost item reported successfully!";

    // --- Matching Logic ---
    $match_query = mysqli_query($conn, "SELECT * FROM found_items WHERE title LIKE '%$title%' AND category='$category'");
    
    if(mysqli_num_rows($match_query) > 0){
        while($match = mysqli_fetch_assoc($match_query)){
            // Create a notification for user
            $message = "A found item matches your lost item: ".$match['title'];
            mysqli_query($conn, "INSERT INTO notifications (user_id, message) VALUES ('$user_id', '$message')");
            
            // Optional: Email notification can be added here
            // sendEmail($user_email, "Found Item Match", $message);
        }
        $success .= " A matching found item was detected! Check your notifications.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Report Lost Item | FindIt</title>
<style>
body { font-family: Arial; background:#f5f5f5; display:flex; justify-content:center; align-items:center; min-height:100vh; margin:0; }
.container { background:#fff; padding:30px; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1); width:450px; max-width:95%; }
h1 { text-align:center; color:#333; margin-bottom:20px; }
form { display:flex; flex-direction:column; }
input, textarea, select, button { margin:10px 0; padding:12px; border-radius:6px; border:1px solid #ccc; width:100%; font-size:16px; }
textarea { resize:none; }
input:focus, textarea:focus, select:focus { outline:none; border-color:#007bff; }
button { background:#007bff; color:#fff; border:none; cursor:pointer; font-weight:bold; transition:0.3s; }
button:hover { background:#0056b3; }
.message { text-align:center; margin:10px 0; color:green; }
@media(max-width:768px){ .container{ width:95%; padding:20px; } input, textarea, select, button{ font-size:14px; padding:10px; } }
</style>
</head>
<body>
<div class="container">
    <h1>Report Lost Item</h1>

    <?php if(isset($success)) echo "<p class='message'>$success</p>"; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Item Title" required>
        <input type="text" name="category" placeholder="Category" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit" name="submit">Submit</button>
    </form>
</div>
</body>
</html>