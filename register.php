<?php
session_start();
include "db.php";

if(isset($_POST['register'])){
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
        $error = "Email already registered!";
    } else {
        mysqli_query($conn,"INSERT INTO users (name,email,password) VALUES ('$name','$email','$hashed_password')");
        $success = "Registration successful!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | FindIt</title>
    <style>
        body { font-family: Arial; background:#f5f5f5; margin:0; padding:0; display:flex; justify-content:center; align-items:center; height:100vh; }
        .container { background:#fff; padding:30px; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1); width:400px; max-width:95%; }
        h1 { text-align:center; color:#333; margin-bottom:20px; }
        form { display:flex; flex-direction:column; }
        input, button { margin:10px 0; padding:12px; border-radius:6px; border:1px solid #ccc; width:100%; font-size:16px; }
        input:focus { outline:none; border-color:#007bff; }
        button { background:#007bff; color:#fff; border:none; cursor:pointer; font-weight:bold; transition:0.3s; }
        button:hover { background:#0056b3; }
        .message { text-align:center; margin:10px 0; }
        a { color:#007bff; text-decoration:none; }
        a:hover { text-decoration:underline; }
        @media(max-width:768px){ .container{ width:95%; padding:20px; } input, button{ font-size:14px; padding:10px; } }
    </style>
</head>
<body>
<div class="container">
    <h1>Register</h1>

    <?php
    if(isset($error)) echo "<p class='message' style='color:red;'>$error</p>";
    if(isset($success)) echo "<p class='message' style='color:green;'>$success</p>";
    ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="register">Register</button>
    </form>

    <!-- LINK OUTSIDE FORM -->
    <p class="message">Already have an account? <a href="login.php">Login here</a></p>
</div>
</body>
</html>