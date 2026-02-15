<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../../user/login.php");
    exit;
}

if(!isset($_GET['id'])){
    echo "No recipe selected!";
    exit;
}

$recipe_id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM recipes WHERE id='$recipe_id'");

if(mysqli_num_rows($result) == 0){
    echo "Recipe not found!";
    exit;
}

$recipe = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo htmlspecialchars($recipe['title']); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{
    font-family:'Segoe UI',sans-serif;
    background:#f4f4f4;
    margin:0;
    padding:0;
}
.container{
    max-width:800px;
    margin:40px auto;
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 6px 15px rgba(0,0,0,0.1);
}
.container img{
    width:60%;
    border-radius:12px;
    margin-bottom:20px;
    margin-left:20%;
}
h1{
    color:#ff6b6b;
}
p{
    color:#555;
    line-height:1.6;
}
label{
    font-weight:bold;
}
.back-btn{
    display:inline-block;
    margin-top:20px;
    padding:8px 12px;
    background:#ffa94d;
    color:white;
    border-radius:6px;
    text-decoration:none;
}
</style>
</head>
<body>

<div class="container">
    <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="Recipe Image">
    <h1><?php echo htmlspecialchars($recipe['title']); ?></h1>
    
    <p><label>Description:</label> <?php echo nl2br(htmlspecialchars($recipe['description'])); ?></p>
    <p><label>Ingredients:</label> <?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>
    <p><label>Steps:</label> <?php echo nl2br(htmlspecialchars($recipe['steps'])); ?></p>

    <a href="view_recipe.php" class="back-btn">← Back to Recipes</a>
</div>

</body>
</html>
