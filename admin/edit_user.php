<?php
include 'config/db.php';

// Check if user ID is provided
if(!isset($_GET['id'])){
    header("Location: manage_users.php");
    exit;
}

$user_id = intval($_GET['id']);

// Fetch user data
$user_result = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
if(mysqli_num_rows($user_result) == 0){
    echo "User not found!";
    exit;
}
$user = mysqli_fetch_assoc($user_result);

// Handle form submission
if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $update_sql = "UPDATE users SET username='$username', email='$email', role='$role' WHERE id='$user_id'";
    if(mysqli_query($conn, $update_sql)){
        header("Location: manage_users.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit User - RECIPICK Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{font-family:'Segoe UI',sans-serif;background:#f4f4f4;margin:0;}
nav{display:flex;justify-content:space-between;align-items:center;padding:15px 40px;background:white;box-shadow:0 2px 8px rgba(0,0,0,0.05);}
nav a{margin-left:20px;text-decoration:none;color:#555;font-weight:500;transition:0.3s;}
nav a:hover{color:#ff6b6b;}
nav .logo{font-size:24px;font-weight:700;color:#ff6b6b;text-decoration:none;}
h2{text-align:center;margin:30px 0;color:#ff6b6b;}
.form-container{max-width:500px;margin:20px auto;background:white;padding:25px;border-radius:12px;box-shadow:0 6px 15px rgba(0,0,0,0.08);}
label{display:block;margin-top:15px;font-weight:600;color:#333;}
input, select{width:100%;padding:10px;margin-top:5px;border-radius:8px;border:1px solid #ddd;outline:none;font-size:14px;}
input:focus, select:focus{border-color:#ff6b6b;}
.btn{display:inline-block;padding:10px 18px;border-radius:8px;border:none;font-size:14px;font-weight:600;cursor:pointer;background:#ff6b6b;color:white;margin-top:20px;transition:0.3s;}
.btn:hover{background:#ff4757;}
.back-btn{background:#333;margin-left:10px;}
.back-btn:hover{background:#000;}
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

<h2>Edit User</h2>

<div class="form-container">
    <form method="post">
        <label>Username</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label>Role</label>
        <select name="role" required>
            <option value="user" <?php if($user['role']=='user') echo 'selected'; ?>>User</option>
            <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>Admin</option>
        </select>

        <button type="submit" name="submit" class="btn">Update</button>
        <a href="manage_users.php" class="btn back-btn">Back</a>
    </form>
</div>

</body>
</html>
