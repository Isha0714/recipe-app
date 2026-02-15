<?php
include 'config/db.php';

$recipes = mysqli_query($conn, "SELECT r.*, u.username FROM recipes r
                                LEFT JOIN users u ON r.user_id = u.id
                                ORDER BY created_at DESC");

if(isset($_GET['approve'])){
    $id = intval($_GET['approve']);
    mysqli_query($conn, "UPDATE recipes SET status='approved' WHERE id='$id'");
    header("Location: manage_recipes.php");
    exit;
}

if(isset($_GET['reject'])){
    $id = intval($_GET['reject']);
    mysqli_query($conn, "DELETE FROM recipes WHERE id='$id'");
    header("Location: manage_recipes.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Recipes - RECIPICK Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{font-family:'Segoe UI',sans-serif;background:#f4f4f4;margin:0;}
nav{display:flex;justify-content:space-between;align-items:center;padding:15px 40px;background:white;box-shadow:0 2px 8px rgba(0,0,0,0.05);}
nav a{margin-left:20px;text-decoration:none;color:#555;font-weight:500;}
nav a:hover{color:#ff6b6b;}
.logo{font-size:24px;font-weight:700;color:#ff6b6b;text-decoration:none;}
table{width:100%;border-collapse:collapse;margin:20px auto;background:white;border-radius:10px;overflow:hidden;box-shadow:0 6px 15px rgba(0,0,0,0.08);}
th,td{padding:12px;text-align:left;border-bottom:1px solid #ddd;}
th{background:#ff6b6b;color:white;}
a.btn{padding:6px 12px;background:#ff6b6b;color:white;text-decoration:none;border-radius:6px;}
a.btn:hover{background:#ff4757;}
</style>
</head>
<body>

<nav>
<a href="dashboard.php" class="logo">RECIPICK Admin</a>
<div>
    <a href="dashboard.php">Dashboard</a>
    <a href="manage_users.php">Users</a>
    <a href="logout.php">Logout</a>
</div>
</nav>

<h2 style="text-align:center;margin-top:20px;">Manage Recipes</h2>

<table>
<tr>
<th>ID</th>
<th>Title</th>
<th>User</th>
<th>Status</th>
<th>Actions</th>
</tr>

<?php while($recipe = mysqli_fetch_assoc($recipes)): ?>
<tr>
<td><?php echo $recipe['id']; ?></td>
<td><?php echo htmlspecialchars($recipe['title']); ?></td>
<td><?php echo htmlspecialchars($recipe['username']); ?></td>
<td>
<?php if($recipe['status']=='pending'): ?>
<span style="background:#ffb86c;color:white;padding:3px 8px;border-radius:5px;font-size:12px;">Pending</span>
<?php else: ?>
<span style="background:#2ed573;color:white;padding:3px 8px;border-radius:5px;font-size:12px;">Approved</span>
<?php endif; ?>
</td>
<td>
<?php if($recipe['status']=='pending'): ?>
<a href="?approve=<?php echo $recipe['id']; ?>" class="btn">Approve</a>
<a href="?reject=<?php echo $recipe['id']; ?>" class="btn">Reject</a>
<?php endif; ?>
<a href="edit_recipes.php?id=<?php echo $recipe['id']; ?>" class="btn">Edit</a>
<a href="delete_recipes.php?id=<?php echo $recipe['id']; ?>" class="btn">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
