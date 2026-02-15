<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../../user/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* Remove Favorite */
if(isset($_GET['remove'])){
    $recipe_id = intval($_GET['remove']);
    mysqli_query($conn, "DELETE FROM favorites WHERE user_id='$user_id' AND recipe_id='$recipe_id'");
    header("Location: favorite.php");
    exit;
}

/* Fetch Favorite Recipes */
$sql = "SELECT recipes.* 
        FROM favorites 
        INNER JOIN recipes ON favorites.recipe_id = recipes.id
        WHERE favorites.user_id = '$user_id'
        ORDER BY favorites.created_at DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>My Favorites</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#f4f4f4;
}

nav{
    display:flex;
    justify-content:space-between; /* logo left, links right */
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


/* HEADER */
header{
    text-align:center;
    padding:30px 20px 10px;
}

header h1{
    color:#ff6b6b;
    font-size:32px;
    margin:0;
}

/* SEARCH */
.search-box{
    text-align:center;
    margin:20px 0 30px;
}

.search-box input{
    width:320px;
    padding:10px 15px;
    border-radius:25px;
    border:1px solid #ddd;
    outline:none;
}

/* GRID */
.recipe-container{
    max-width:1100px;
    margin:auto;
    padding:20px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

/* CARD */
.recipe-card{
    background:white;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 6px 15px rgba(0,0,0,0.08);
    transition:0.3s;
}

.recipe-card:hover{
    transform:translateY(-5px);
}

.recipe-card img{
    width:100%;
    height:180px;
    object-fit:cover;
}

.recipe-content{
    padding:15px;
}

.recipe-content h3{
    margin:0;
    color:#333;
}

.recipe-content p{
    font-size:14px;
    color:#777;
    margin:5px 0 12px;
}

/* BUTTON */
.btn{
    display:inline-block;
    padding:8px 12px;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
    font-weight:500;
    background:#333;
    color:white;
}

.btn:hover{
    background:#000;
}

footer{
    text-align:center;
    padding:20px;
    margin-top:40px;
    background:white;
    color:#777;
}
</style>
</head>

<body>

<!-- NAV -->
<nav>
    <!-- LOGO -->
    <a href="index.php" class="logo">RECIPICK</a>

    <!-- NAV LINKS -->
  <div class="nav-links">
        <a href="../index.php">Home</a>
        <a href="../index.php#about">About</a>
        <a href="view_recipe.php">Recipes</a>
        <a href="../index.php#contact">Contact</a>

   
    </div>
</nav>

<!-- HEADER -->
<header>
    <h1>My Favorite Recipes ❤️</h1>
</header>

<!-- SEARCH -->
<div class="search-box">
    <input type="text" id="searchInput" placeholder="Search favorites...">
</div>

<!-- FAVORITES GRID -->
<section class="recipe-container">

<?php
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
?>
    <div class="recipe-card">
        <?php if($row['image']){ ?>
            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Recipe Image">
        <?php } ?>

        <div class="recipe-content">
            <h3 class="recipe-title"><?php echo htmlspecialchars($row['title']); ?></h3>
            <p><?php echo substr(htmlspecialchars($row['description']),0,60); ?>...</p>

            <a href="?remove=<?php echo $row['id']; ?>" class="btn">❤️ Remove</a>
        </div>
    </div>
<?php
    }
} else {
    echo "<p style='text-align:center;'>No favorite recipes yet.</p>";
}
?>

</section>

<footer>
    &copy; 2026 Recipe App. All Rights Reserved.
</footer>

<!-- SEARCH SCRIPT -->
<script>
document.getElementById("searchInput").addEventListener("keyup", function(){
    let filter = this.value.toLowerCase();
    let cards = document.querySelectorAll(".recipe-card");

    cards.forEach(function(card){
        let title = card.querySelector(".recipe-title").textContent.toLowerCase();
        if(title.includes(filter)){
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
});
</script>

</body>
</html>
