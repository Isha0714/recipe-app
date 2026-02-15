<?php
include 'config/db.php';

// Check if user ID is provided
if(!isset($_GET['id'])){
    header("Location: manage_users.php");
    exit;
}

$user_id = intval($_GET['id']);

// Delete user
mysqli_query($conn, "DELETE FROM users WHERE id='$user_id'");

// Redirect back
header("Location: manage_users.php");
exit;
