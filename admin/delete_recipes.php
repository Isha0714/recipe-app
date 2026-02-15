<?php
include 'config/db.php';

if(!isset($_GET['id'])){
    header("Location: manage_recipes.php");
    exit;
}

$recipe_id = intval($_GET['id']);

// Fetch the recipe to delete image file if exists
$recipe_result = mysqli_query($conn, "SELECT * FROM recipes WHERE id='$recipe_id'");
if(mysqli_num_rows($recipe_result) > 0){
    $recipe = mysqli_fetch_assoc($recipe_result);

    // Delete image file if exists
    if($recipe['image'] && file_exists('../'.$recipe['image'])){
        unlink('../'.$recipe['image']);
    }

    // Delete recipe from DB
    mysqli_query($conn, "DELETE FROM recipes WHERE id='$recipe_id'");
}

header("Location: manage_recipes.php");
exit;
?>
