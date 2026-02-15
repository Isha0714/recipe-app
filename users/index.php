<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>RECIPICK</title>
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

/* ACCOUNT DROPDOWN MODERN STYLE */
.account-dropdown {
    position: relative;
    display: inline-block;
    margin-left: 20px;
}

.account-dropdown .main-btn {
    cursor: pointer;
    background: #ff6b6b;
    color: white;
    padding: 8px 14px;
    border-radius: 6px;
    font-weight: 600;
    border: none;
    outline: none;
    transition: 0.3s;
}

.account-dropdown .main-btn:hover {
    background: #ff4757;
}

.account-dropdown .dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background: #fff;
    min-width: 250px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    border-radius: 10px;
    padding: 15px;
    z-index: 1000;
    text-align: left;
    animation: fadeIn 0.3s ease-in-out;
}

.account-dropdown:hover .dropdown-content {
    display: block;
}

.account-dropdown .dropdown-content p {
    margin: 10px 0;
    font-size: 14px;
    color: #333;
    display: flex;
    align-items: center;
    gap: 8px;
}

.account-dropdown .dropdown-content p::before {
    content: "•";  
    color: #ff6b6b;
}

.account-dropdown .dropdown-content .logout-btn {
    display: block;
    margin-top: 15px;
    padding: 8px 12px;
    background: #ff6b6b;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    text-align: center;
    transition: 0.3s;
}

.account-dropdown .dropdown-content .logout-btn:hover {
    background: #ff4757;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* HERO SECTION */
.hero{
    height:600px;
    display:flex;
    justify-content:center;
    align-items:center;
    flex-direction:column;
    text-align:center;
    background: 
        linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
        url('image/background.jpg') no-repeat center center;
    background-size: cover;
    color:white;
}

.hero h1{
    font-size:48px;
    margin:0;
}

.hero p{
    font-size:18px;
    margin:15px 0;
    max-width:600px;
}

.btn{
    display:inline-block;
    padding:12px 25px;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
    background:white;
    color:#ff6b6b;
    transition:0.3s;
}

.btn:hover{
    background:#ffe3e3;
}

/* SECTIONS */
section{
    max-width:1000px;
    margin:60px auto;
    padding:20px;
    text-align:center;
}

section h2{
    color:#333;
    margin-bottom:20px;
}

section p{
    color:#666;
    line-height:1.6;
}

/* FEATURE BOXES */
.features{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
    margin-top:30px;
}

.feature-box{
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 6px 15px rgba(0,0,0,0.08);
    transition:0.3s;
}

.feature-box:hover{
    transform:translateY(-5px);
}

.feature-box h3{
    margin:0 0 10px;
    color:#ff6b6b;
}

/* FOOTER */
footer{
    text-align:center;
    padding:20px;
    background:white;
    color:#777;
    margin-top:40px;
}
</style>
</head>

<body>

<!-- NAVIGATION -->
<nav>
    <!-- LOGO -->
    <a href="index.php" class="logo">RECIPICK</a>

    <!-- NAV LINKS -->
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="#about">About</a>
        <a href="recipe/view_recipe.php">Recipes</a>
        <a href="#contact">Contact</a>

        <?php
        if(isset($_SESSION['user_id'])){
            include 'config/db.php';
            $user_id = $_SESSION['user_id'];
            $user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
            $user = mysqli_fetch_assoc($user_query);
        ?>
            <div class="account-dropdown">
                <button class="main-btn"><?php echo htmlspecialchars($user['username']); ?> ▼</button>
                <div class="dropdown-content">
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <a href="logout.php" class="logout-btn">Logout</a>
                </div>
            </div>
        <?php } else { ?>
            <a href="login.php" class="main-btn">Login</a>
        <?php } ?>
    </div>
</nav>

<!-- HERO -->
<div class="hero">
    <h1>Welcome to RECIPICK</h1>
    <p>Discover delicious recipes, add your own creations, and save your favorites in one beautiful place.</p>
    <a href="recipe/view_recipe.php" class="btn">Explore Recipes</a>
</div>

<!-- ABOUT -->
<section id="about">
    <h2>About Us</h2>
    <p>
        RECIPICK is a simple and modern platform where users can explore,
        share, and save their favorite recipes. Built with love for food enthusiasts.
    </p>

    <div class="features">
        <div class="feature-box">
            <h3>🍲 Explore Recipes</h3>
            <p>Browse a wide variety of delicious recipes shared by users.</p>
        </div>

        <div class="feature-box">
            <h3>➕ Add Your Own</h3>
            <p>Create and share your personal cooking masterpieces.</p>
        </div>

        <div class="feature-box">
            <h3>❤️ Save Favorites</h3>
            <p>Keep all your favorite recipes in one convenient place.</p>
        </div>
    </div>
</section>

<!-- CONTACT -->
<section id="contact">
    <h2>Contact Us</h2>
    <p>Email: support@recipeapp.com</p>
    <p>Phone: +123 456 7890</p>
</section>

<footer>
    &copy; 2026 RECIPICK. All Rights Reserved.
</footer>

</body>
</html>
