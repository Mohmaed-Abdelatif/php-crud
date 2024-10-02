<?php
// Include the DB class file
require("./func/connectDB.php");

$id = $_GET['id'];

$db = new DB();

$user_data = $db->getUserData('user', $id);

// Check if user data exists
if (!$user_data) {
    die('User not found');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
</head>

<body>
    <h3>Name: <?= $user_data['name'] ?></h3>
    <h3>Email: <?= $user_data['email'] ?></h3>
    <h3>Image(s):
        <?php
        // Handle multiple images (assuming they are comma-separated)
        $images = explode(',', $user_data['image']);
        foreach ($images as $image) {
        ?>
            <img src='img/<?= trim($image) ?>' alt="user image" style='height:80px; width:80px; margin-right:20px;'>
        <?php
        }
        ?>
    </h3>
</body>

</html>
