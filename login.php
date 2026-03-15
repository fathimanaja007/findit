<?php
session_start();
include "db.php";

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    $res = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($res) > 0){
        $row = mysqli_fetch_assoc($res);
        if(password_verify($password,$row['password'])){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Email not registered!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | FindIt</title>
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
    <h1>Login</h1>

    <?php if(isset($error)) echo "<p class='message' style='color:red;'>$error</p>"; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>

    <p class="message">Don't have an account? <a href="register.php">Register here</a></p>
</div>
</body>
</html>