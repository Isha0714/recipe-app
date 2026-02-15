<?php
session_start();

// Redirect if already logged in
if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true){
    header("Location: dashboard.php");
    exit;
}

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    if($email === "admin@gmail.com" && $password === "admin123"){
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login - RECIPICK</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{font-family:'Segoe UI',sans-serif;background:#f4f4f4;margin:0;}
.login-container{max-width:400px;margin:100px auto;background:white;padding:30px;border-radius:12px;box-shadow:0 6px 15px rgba(0,0,0,0.08);}
h2{text-align:center;color:#ff6b6b;margin-bottom:20px;}
input{width:100%;padding:10px;margin:10px 0;border-radius:8px;border:1px solid #ddd;outline:none;}
input:focus{border-color:#ff6b6b;}
button{width:100%;padding:10px;background:#ff6b6b;color:white;border:none;border-radius:8px;font-weight:600;cursor:pointer;transition:0.3s;}
button:hover{background:#ff4757;}
.error{color:red;text-align:center;}
</style>
</head>
<body>

<div class="login-container">
<h2>Admin Login</h2>
<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
<form method="post">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="submit">Login</button>
</form>
</div>

</body>
</html>
