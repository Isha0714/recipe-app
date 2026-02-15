<?php
session_start();
include 'config/db.php';

// Access control
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true){
    header("Location: login.php");
    exit;
}

// Count users
$user_count_result = mysqli_query($conn, "SELECT COUNT(*) as total_users FROM users");
$user_count = mysqli_fetch_assoc($user_count_result)['total_users'];

// Count recipes
$recipe_count_result = mysqli_query($conn, "SELECT COUNT(*) as total_recipes FROM recipes");
$recipe_count = mysqli_fetch_assoc($recipe_count_result)['total_recipes'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard - RECIPICK</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{font-family:'Segoe UI',sans-serif;background:#f4f4f4;margin:0;}
nav{display:flex;justify-content:space-between;align-items:center;padding:15px 40px;background:white;box-shadow:0 2px 8px rgba(0,0,0,0.05);}
nav .logo{font-size:24px;font-weight:700;color:#ff6b6b;text-decoration:none;}
nav div a{margin-left:20px;text-decoration:none;color:#555;font-weight:500;padding:6px 12px;border-radius:6px;transition:0.3s;}
nav div a:hover{background:#ff6b6b;color:#fff;}
header{text-align:center;background:linear-gradient(135deg,#ff6b6b,#ffb86c);color:white;padding:40px 20px;box-shadow:0 4px 15px rgba(0,0,0,0.1);}
header h1{margin:0;font-size:36px;letter-spacing:1px;}
.dashboard{display:flex;gap:20px;flex-wrap:wrap;padding:40px 20px;max-width:1000px;margin:auto;}
.card{flex:1 1 250px;background:#fff;padding:30px 20px;border-radius:15px;box-shadow:0 6px 20px rgba(0,0,0,0.08);text-align:center;transition:transform 0.3s,box-shadow 0.3s;}
.card:hover{transform:translateY(-5px);box-shadow:0 10px 25px rgba(0,0,0,0.15);}
.card h2{color:#ff6b6b;margin:0;font-size:42px;}
.card p{color:#555;font-weight:600;margin-top:10px;font-size:18px;}
@media(max-width:768px){
nav{flex-direction:column;align-items:flex-start;}
nav div{display:flex;flex-direction:column;width:100%;margin-top:10px;}
nav div a{margin:5px 0;}
.dashboard{flex-direction:column;align-items:center;}
.card{width:90%;}
}
</style>
</head>
<body>

<nav>
<a href="dashboard.php" class="logo">RECIPICK Admin</a>
<div>
    <a href="manage_users.php">Users</a>
    <a href="manage_recipes.php">Recipes</a>
    <a href="logout.php">Logout</a>
</div>
</nav>

<header>
<h1>Admin Dashboard</h1>
</header>

<div class="dashboard">
<div class="card">
    <h2><?php echo $user_count; ?></h2>
    <p>Total Users</p>
</div>
<div class="card">
    <h2><?php echo $recipe_count; ?></h2>
    <p>Total Recipes</p>
</div>
</div>

</body>
</html>
