<?php
session_start();
include 'config/db.php';




// Fetch all ratings
$rating_result = mysqli_query($conn, "
    SELECT ra.id as rating_id, u.username, r.title as recipe_title, ra.rating, ra.created_at 
    FROM ratings ra
    JOIN users u ON ra.user_id = u.id
    JOIN recipes r ON ra.recipe_id = r.id
    ORDER BY ra.created_at DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Ratings - RECIPICK Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            margin: 0;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        nav a.logo {
            font-size: 24px;
            font-weight: 700;
            color: #ff6b6b;
            text-decoration: none;
        }

        nav div a {
            margin-left: 20px;
            text-decoration: none;
            color: #555;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 6px;
            transition: 0.3s;
        }

        nav div a:hover {
            background: #ff6b6b;
            color: white;
        }

        h2 {
            text-align: center;
            margin: 30px 0 20px;
            color: #ff6b6b;
        }

        table {
            width: 90%;
            margin: 0 auto 50px;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #ff6b6b;
            color: white;
        }

        a.btn {
            padding: 6px 12px;
            background: #ff6b6b;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
        }

        a.btn:hover {
            background: #ff4757;
        }

        @media(max-width:768px) {

            table,
            th,
            td {
                font-size: 12px;
            }

            nav {
                flex-direction: column;
                align-items: flex-start;
            }

            nav div {
                display: flex;
                flex-direction: column;
                width: 100%;
                margin-top: 10px;
            }

            nav div a {
                margin: 5px 0;
            }
        }
    </style>
</head>

<body>

    <nav>
        <a href="dashboard.php" class="logo">RECIPICK Admin</a>
        <div>
            <a href="manage_users.php">Users</a>
            <a href="manage_recipes.php">Recipes</a>
            <a href="manage_favorites.php">Favorites</a>
             <a href="logout.php">Logout</a>
        </div>
    </nav>

    <h2>All Ratings</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Recipe</th>
            <th>Rating</th>
            <th>Rated At</th>
            <th>Actions</th>
        </tr>
        <?php while ($rate = mysqli_fetch_assoc($rating_result)) { ?>
            <tr>
                <td><?php echo $rate['rating_id']; ?></td>
                <td><?php echo htmlspecialchars($rate['username']); ?></td>
                <td><?php echo htmlspecialchars($rate['recipe_title']); ?></td>
                <td><?php echo $rate['rating']; ?> ★</td>
                <td><?php echo $rate['created_at']; ?></td>
                <td>
                    <a href="delete_rating.php?id=<?php echo $rate['rating_id']; ?>" class="btn"
                        onclick="return confirm('Delete this rating?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

</body>

</html>