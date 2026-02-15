<?php
session_start();
include 'config/db.php';

if(isset($_POST['login'])){
    $email=$_POST['email'];
    $password=$_POST['password'];

    $sql="SELECT * FROM users WHERE email='$email' AND role='user'";
    $result=mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)>0){
        $user=mysqli_fetch_assoc($result);
        if(password_verify($password,$user['password'])){
            $_SESSION['user_id']=$user['id'];
            $_SESSION['username']=$user['username'];
            header("Location: index.php");
        } else $error="Invalid password!";
    } else $error="User not found!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <style>
        body { font-family:'Segoe UI',sans-serif; background:#f5f5f5; display:flex; justify-content:center; align-items:center; height:100vh; }
        .login-box { background:white; padding:40px; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.1); width:350px; text-align:center; }
        h2 { color:#ff6b6b; margin-bottom:20px; }
        input { width:100%; padding:10px; margin:10px 0; border-radius:5px; border:1px solid #ccc; }
        input[type=submit] { background:#ff6b6b; color:white; border:none; font-weight:bold; cursor:pointer; transition:0.3s; }
        input[type=submit]:hover { background:#ff4757; }
        p.error { color:red; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>User Login</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" name="login" value="Login">
    </form>
</div>
</body>
</html>
