<?php
include 'config/db.php';

if(!isset($_GET['id'])){
    header("Location: manage_recipes.php");
    exit;
}

$recipe_id = intval($_GET['id']);

// Fetch existing recipe
$recipe_result = mysqli_query($conn, "SELECT * FROM recipes WHERE id='$recipe_id'");
if(mysqli_num_rows($recipe_result) == 0){
    echo "Recipe not found!";
    exit;
}
$recipe = mysqli_fetch_assoc($recipe_result);

// Handle form submission
if(isset($_POST['update'])){
    $title = mysqli_real_escape_string($conn,$_POST['title']);
    $description = mysqli_real_escape_string($conn,$_POST['description']);
    $ingredients = mysqli_real_escape_string($conn,$_POST['ingredients']);
    $steps = mysqli_real_escape_string($conn,$_POST['steps']);

    $image_path = $recipe['image']; // Keep old image by default
    if(isset($_FILES['image']) && $_FILES['image']['name'] != ''){
        $filename = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/'.$filename);
        $image_path = 'uploads/'.$filename;
    }

    mysqli_query($conn, "UPDATE recipes SET 
        title='$title',
        description='$description',
        ingredients='$ingredients',
        steps='$steps',
        image='$image_path'
        WHERE id='$recipe_id'");

    header("Location: manage_recipes.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Recipe - RECIPICK</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{font-family:'Segoe UI',sans-serif;background:#f4f4f4;margin:0;}
.container{max-width:500px;margin:40px auto;background:white;padding:30px;border-radius:12px;box-shadow:0 6px 15px rgba(0,0,0,0.1);}
input,textarea{width:100%;padding:10px;margin-bottom:15px;border-radius:6px;border:1px solid #ddd;}
button{width:100%;padding:10px;background:#ff6b6b;color:white;border:none;border-radius:6px;cursor:pointer;font-weight:600;}
button:hover{background:#ff4757;}
img{max-width:100%;margin-bottom:15px;border-radius:6px;}
</style>
</head>
<body>

<div class="container">
<h2>Edit Recipe</h2>
<form method="POST" enctype="multipart/form-data">
<input type="text" name="title" placeholder="Title" value="<?php echo htmlspecialchars($recipe['title']); ?>" required>
<textarea name="description" placeholder="Description" required><?php echo htmlspecialchars($recipe['description']); ?></textarea>
<textarea name="ingredients" placeholder="Ingredients" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea>
<textarea name="steps" placeholder="Steps" required><?php echo htmlspecialchars($recipe['steps']); ?></textarea>

<?php if($recipe['image']){ ?>
<img src="../<?php echo $recipe['image']; ?>" alt="Recipe Image">
<?php } ?>

<input type="file" name="image">
<button type="submit" name="update">Update Recipe</button>
</form>
</div>

</body>
</html>
