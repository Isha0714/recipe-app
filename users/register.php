<?php
session_start();
include 'config/db.php'; // Adjust path to your DB config

if(isset($_POST['register'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if($password !== $confirm_password){
        $error = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR email='$email'");
        if(mysqli_num_rows($check) > 0){
            $error = "Username or email already exists!";
        } else {
            $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', 'user')";
            if(mysqli_query($conn, $sql)){
                $_SESSION['user_id'] = mysqli_insert_id($conn);
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit;
            } else {
                $error = "Database error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Recipe App</title>
    <style>
        body { font-family:'Segoe UI',sans-serif; background:#f5f5f5; display:flex; justify-content:center; align-items:center; height:100vh; }
        .login-box { background:white; padding:40px; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.1); width:350px; text-align:center; }
        h2 { color:#ff6b6b; margin-bottom:20px; }
        input { width:100%; padding:10px; margin:10px 0; border-radius:5px; border:1px solid #ccc; }
        button { width:100%; padding:10px; margin-top:10px; background:#ff6b6b; color:white; border:none; font-weight:bold; cursor:pointer; border-radius:5px; transition:0.3s; }
        button:hover { background:#ff4757; }
        p.error { color:red; }
        a { color:#ff6b6b; text-decoration:none; }
        a:hover { text-decoration:underline; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Register</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
        <button type="submit" name="register">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login Here</a></p>
</div>
</body>
</html>
