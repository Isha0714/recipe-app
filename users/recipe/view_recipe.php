<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../../user/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* Favorite Toggle */
if(isset($_GET['favorite'])){
    $recipe_id = intval($_GET['favorite']);

    $check = mysqli_query($conn, "SELECT * FROM favorites WHERE user_id='$user_id' AND recipe_id='$recipe_id'");

    if(mysqli_num_rows($check) > 0){
        mysqli_query($conn, "DELETE FROM favorites WHERE user_id='$user_id' AND recipe_id='$recipe_id'");
    } else {
        mysqli_query($conn, "INSERT INTO favorites (user_id, recipe_id) VALUES ('$user_id', '$recipe_id')");
    }

    header("Location: view_recipe.php");
    exit;
}

// Only show approved recipes
$result = mysqli_query($conn, "SELECT * FROM recipes WHERE status='approved' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>All Recipes - RECIPICK</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#f4f4f4;
}

/* NAVBAR */
nav{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 40px;
    background:white;
    box-shadow:0 2px 8px rgba(0,0,0,0.05);
}

nav .logo{
    font-size:24px;
    font-weight:700;
    color:#ff6b6b;
    text-decoration:none;
}

nav .nav-links{
    display:flex;
    align-items:center;
}

nav .nav-links a{
    margin-left:20px;
    text-decoration:none;
    color:#555;
    font-weight:500;
    transition:0.3s;
}

nav .nav-links a:hover{
    color:#ff6b6b;
}

.add-btn{background:#ffa94d;color:white;padding:6px 14px;border-radius:6px;text-decoration:none;font-weight:500;transition:0.3s;}
.add-btn:hover{background:#ff922b;}

header{text-align:center;padding:30px 20px 10px;}
header h1{color:#ff6b6b;font-size:32px;margin:0;}

/* SEARCH + FAVORITES BUTTON */
.search-box{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:10px;
    margin:20px 0 30px;
    flex-wrap:wrap;
}

.search-box input{
    padding:10px 15px;
    border-radius:25px;
    border:1px solid #ddd;
    outline:none;
    width:300px;
}

.search-box .btn-fav{
    padding:10px 15px;
    border-radius:25px;
    border:1px solid #ddd;
    background:#fff;
    color:#ff6b6b;
    font-weight:500;
    text-decoration:none;
    transition:0.3s;
}

.search-box .btn-fav:hover{
    background:#ff6b6b;
    color:#fff;
}

/* RECIPES GRID */
.recipe-container{
    max-width:1100px;
    margin:auto;
    padding:20px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

.recipe-card{
    background:white;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 6px 15px rgba(0,0,0,0.08);
    transition:0.3s;
}

.recipe-card:hover{transform:translateY(-5px);}
.recipe-card img{width:100%;height:180px;object-fit:cover;}
.recipe-content{padding:15px;}
.recipe-content h3{margin:0;color:#333;}
.recipe-content p{font-size:14px;color:#777;margin:5px 0 12px;}
.btn-card{display:inline-block;padding:8px 12px;border-radius:6px;text-decoration:none;font-size:14px;font-weight:500;background:#ff6b6b;color:white;margin-right:5px;}
.btn-card:hover{background:#ff4757;}
.unfav{background:#333;}

footer{text-align:center;padding:20px;margin-top:40px;background:white;color:#777;}
</style>
</head>

<body>

<!-- NAV -->
<nav>
    <a href="../index.php" class="logo">RECIPICK</a>

    <div class="nav-links">
        <a href="../index.php">Home</a>
        <a href="../index.php#about">About</a>
        <a href="view_recipe.php">Recipes</a>
        <a href="add_recipe.php" class="add-btn">➕ Add Recipe</a>
        <a href="../index.php#contact">Contact</a>
    </div>
</nav>

<!-- HEADER -->
<header>
    <h1>All Recipes</h1>
</header>

<!-- SEARCH + FAVORITES -->
<div class="search-box">
    <input type="text" id="searchInput" placeholder="Search recipes...">
    <a href="favorite.php" class="btn-fav">❤️ Favorites</a>
</div>

<!-- RECIPES -->
<section class="recipe-container" id="recipeContainer">
<?php
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $recipe_id = $row['id'];
        $fav_check = mysqli_query($conn, "SELECT * FROM favorites WHERE user_id='$user_id' AND recipe_id='$recipe_id'");
        $is_fav = mysqli_num_rows($fav_check) > 0;
?>
    <div class="recipe-card">
        <?php if($row['image']){ ?>
            <a href="recipe_details.php?id=<?php echo $recipe_id; ?>">
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Recipe Image">
            </a>
        <?php } ?>

        <div class="recipe-content">
            <h3 class="recipe-title"><?php echo htmlspecialchars($row['title']); ?></h3>
            <p><?php echo substr(htmlspecialchars($row['description']),0,60); ?>...</p>

            <?php if($is_fav){ ?>
                <a href="?favorite=<?php echo $recipe_id; ?>" class="btn-card unfav">❤️ Unfavorite</a>
            <?php } else { ?>
                <a href="?favorite=<?php echo $recipe_id; ?>" class="btn-card">🤍 Add to Favorite</a>
            <?php } ?>
        </div>
    </div>
<?php
    }
} else {
    echo "<p style='text-align:center;'>No recipes found.</p>";
}
?>
</section>

<footer>
    &copy; 2026 Recipe App. All Rights Reserved.
</footer>

<script>
document.getElementById("searchInput").addEventListener("keyup", function(){
    let filter = this.value.toLowerCase();
    let cards = document.querySelectorAll(".recipe-card");

    cards.forEach(function(card){
        let title = card.querySelector(".recipe-title").textContent.toLowerCase();
        card.style.display = title.includes(filter) ? "block" : "none";
    });
});
</script>

</body>
</html>
