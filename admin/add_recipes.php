<?php
include 'config/db.php';

if(isset($_POST['submit'])){
    $title = mysqli_real_escape_string($conn,$_POST['title']);
    $description = mysqli_real_escape_string($conn,$_POST['description']);
    $ingredients = mysqli_real_escape_string($conn,$_POST['ingredients']);
    $steps = mysqli_real_escape_string($conn,$_POST['steps']);

    $image_path = '';
    if(isset($_FILES['image']) && $_FILES['image']['name'] != ''){
        $filename = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/'.$filename);
        $image_path = 'uploads/'.$filename;
    }

    mysqli_query($conn, "INSERT INTO recipes (title, description, ingredients, steps, image, created_at) VALUES ('$title','$description','$ingredients','$steps','$image_path', NOW())");
    header("Location: manage_recipes.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Recipe - RECIPICK</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{font-family:'Segoe UI',sans-serif;background:#f4f4f4;margin:0;}
.container{max-width:500px;margin:40px auto;background:white;padding:30px;border-radius:12px;box-shadow:0 6px 15px rgba(0,0,0,0.1);}
input,textarea{width:100%;padding:10px;margin-bottom:15px;border-radius:6px;border:1px solid #ddd;}
button{width:100%;padding:10px;background:#ff6b6b;color:white;border:none;border-radius:6px;cursor:pointer;font-weight:600;}
button:hover{background:#ff4757;}
</style>
</head>
<body>

<div class="container">
<h2>Add Recipe</h2>
<form method="POST" enctype="multipart/form-data">
<input type="text" name="title" placeholder="Title" required>
<textarea name="description" placeholder="Description" required></textarea>
<textarea name="ingredients" placeholder="Ingredients" required></textarea>
<textarea name="steps" placeholder="Steps" required></textarea>
<input type="file" name="image">
<button type="submit" name="submit">Add Recipe</button>
</form>
</div>

</body>
</html>
