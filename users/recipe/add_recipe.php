<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../../user/login.php");
    exit;
}

if(isset($_POST['submit'])){
    $user_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $steps = mysqli_real_escape_string($conn, $_POST['steps']);

    $image = "";
    if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
        $target_dir = "uploads/";
        if(!is_dir($target_dir)){
            mkdir($target_dir, 0777, true);
        }
        $image = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image);
    }

    $sql = "INSERT INTO recipes (user_id, title, description, ingredients, steps, image, status)
            VALUES ('$user_id', '$title', '$description', '$ingredients', '$steps', '$image', 'pending')";

    if(mysqli_query($conn, $sql)){
        header("Location: view_recipe.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Recipe - RECIPICK</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{margin:0;font-family:'Segoe UI',sans-serif;background:#f4f4f4;}
nav{display:flex;justify-content:space-between;align-items:center;padding:15px 40px;background:white;box-shadow:0 2px 8px rgba(0,0,0,0.05);}
nav .logo{font-size:24px;font-weight:700;color:#ff6b6b;text-decoration:none;}
nav .nav-links{display:flex;align-items:center;}
nav .nav-links a{margin-left:20px;text-decoration:none;color:#555;font-weight:500;transition:0.3s;}
nav .nav-links a:hover{color:#ff6b6b;}
header{text-align:center;padding:30px 20px 10px;}
header h1{color:#ff6b6b;font-size:32px;margin:0;}
.form-container{max-width:600px;margin:30px auto;background:white;padding:30px;border-radius:12px;box-shadow:0 6px 15px rgba(0,0,0,0.08);}
label{display:block;margin-top:15px;font-weight:600;color:#333;}
input[type=text], textarea, input[type=file]{width:100%;padding:10px 12px;margin-top:5px;border-radius:8px;border:1px solid #ddd;outline:none;font-size:14px;}
textarea{resize:vertical;min-height:100px;}
input[type=text]:focus, textarea:focus{border-color:#ff6b6b;}
.btn{display:inline-block;padding:10px 18px;border-radius:8px;border:none;font-size:14px;font-weight:600;cursor:pointer;background:#ff6b6b;color:white;margin-top:20px;transition:0.3s;}
.btn:hover{background:#ff4757;}
.back-btn{background:#333;margin-left:10px;}
.back-btn:hover{background:#000;}
footer{text-align:center;padding:20px;margin-top:40px;background:white;color:#777;}
</style>
</head>
<body>

<nav>
    <a href="index.php" class="logo">RECIPICK</a>
    <div class="nav-links">
        <a href="../index.php">Home</a>
        <a href="../index.php#about">About</a>
        <a href="view_recipe.php">Recipes</a>
        <a href="../index.php#contact">Contact</a>
    </div>
</nav>

<header>
<h1>Add a New Recipe</h1>
</header>

<div class="form-container">
    <form method="post" enctype="multipart/form-data">
        <label>Title</label>
        <input type="text" name="title" required>

        <label>Description</label>
        <textarea name="description" required></textarea>

        <label>Ingredients</label>
        <textarea name="ingredients" required></textarea>

        <label>Steps</label>
        <textarea name="steps" required></textarea>

        <label>Image (Optional)</label>
        <input type="file" name="image">

        <button type="submit" name="submit" class="btn">Add Recipe</button>
        <a href="view_recipe.php" class="btn back-btn">Back</a>
    </form>
</div>

<footer>
&copy; 2026 RECIPICK. All Rights Reserved.
</footer>
</body>
</html>
