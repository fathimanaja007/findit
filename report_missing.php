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

// Handle form submission
if(isset($_POST['submit'])){
    $user_id = $_SESSION['user_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = intval($_POST['age']);
    $last_seen = mysqli_real_escape_string($conn, $_POST['last_seen']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);

    // Handle image upload
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $upload_dir = "uploads/";
    move_uploaded_file($tmp_name, $upload_dir.$image);

    mysqli_query($conn, "INSERT INTO missing_persons (user_id, name, age, last_seen, contact, image) VALUES ('$user_id', '$name', '$age', '$last_seen', '$contact', '$image')");
    $success = "Missing person reported successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Report Missing Person | FindIt</title>
<style>
body {
    font-family: Arial, sans-serif;
    background:#f5f5f5;
    margin:0;
    padding:0;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}
.container {
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 4px 20px rgba(0,0,0,0.1);
    width:450px;
    max-width:95%;
}
h1 { text-align:center; color:#333; margin-bottom:20px; }
form { display:flex; flex-direction:column; }
input, textarea, select, button {
    margin:10px 0;
    padding:12px;
    border-radius:6px;
    border:1px solid #ccc;
    width:100%;
    font-size:16px;
}
textarea { resize:none; }
input:focus, textarea:focus, select:focus { outline:none; border-color:#007bff; }
button {
    background:#007bff;
    color:#fff;
    border:none;
    cursor:pointer;
    font-weight:bold;
    transition:0.3s;
}
button:hover { background:#0056b3; }
.message { text-align:center; margin:10px 0; color:green; }
@media(max-width:768px){
    .container{ width:95%; padding:20px; }
    input, textarea, select, button{ font-size:14px; padding:10px; }
}
</style>
</head>
<body>
<div class="container">
    <h1>Report Missing Person</h1>

    <?php if(isset($success)) { echo "<p class='message'>$success</p>"; } ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Person Name" required>
        <input type="number" name="age" placeholder="Age" required>
        <input type="text" name="last_seen" placeholder="Last Seen Location" required>
        <input type="text" name="contact" placeholder="Contact Number" required>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit" name="submit">Submit</button>
    </form>
</div>
</body>
</html>