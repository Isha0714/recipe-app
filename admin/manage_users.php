<?php
include 'config/db.php';

// Fetch all users
$users_result = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Users - RECIPICK Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body {
    font-family:'Segoe UI',sans-serif;
    background:#f4f4f4;
    margin:0;
}

/* NAVBAR */
nav {
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 40px;
    background:white;
    box-shadow:0 2px 8px rgba(0,0,0,0.05);
}

nav a {
    margin-left:20px;
    text-decoration:none;
    color:#555;
    font-weight:500;
    transition:0.3s;
}

nav a:hover {
    color:#ff6b6b;
}

nav .logo {
    font-size:24px;
    font-weight:700;
    color:#ff6b6b;
    text-decoration:none;
}

/* HEADER */
h2 {
    text-align:center;
    margin:30px 0 20px;
    color:#ff6b6b;
}

/* TABLE */
table {
    width:90%;
    margin:0 auto 50px;
    border-collapse:collapse;
    background:white;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 6px 15px rgba(0,0,0,0.08);
}

th, td {
    padding:12px;
    text-align:left;
    border-bottom:1px solid #ddd;
}

th {
    background:#ff6b6b;
    color:white;
}

/* BUTTONS */
a.btn {
    padding:6px 12px;
    background:#ff6b6b;
    color:white;
    text-decoration:none;
    border-radius:6px;
    font-size:14px;
}

a.btn:hover {
    background:#ff4757;
}

/* RESPONSIVE */
@media(max-width:768px){
    table, th, td {
        font-size:12px;
    }
    nav {
        flex-direction:column;
        align-items:flex-start;
    }
    nav div {
        display:flex;
        flex-direction:column;
        width:100%;
        margin-top:10px;
    }
    nav div a {
        margin:5px 0;
    }
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <a href="dashboard.php" class="logo">RECIPICK Admin</a>
    <div>
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_recipes.php">Recipes</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<!-- HEADER -->
<h2>Manage Users</h2>

<!-- USERS TABLE -->
<table>
<tr>
<th>ID</th>
<th>Username</th>
<th>Email</th>
<th>Role</th>
<th>Created At</th>
<th>Actions</th>
</tr>

<?php while($user = mysqli_fetch_assoc($users_result)){ ?>
<tr>
<td><?php echo $user['id']; ?></td>
<td><?php echo htmlspecialchars($user['username']); ?></td>
<td><?php echo htmlspecialchars($user['email']); ?></td>
<td><?php echo $user['role']; ?></td>
<td><?php echo $user['created_at']; ?></td>
<td>
<a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn">Edit</a>
<a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
</td>
</tr>
<?php } ?>
</table>

</body>
</html>
