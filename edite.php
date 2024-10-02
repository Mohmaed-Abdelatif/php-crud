<?php
session_start();
$id = $_GET['id'];

include("func/connectDB.php");
$db = new DB();

$user = $db->getUserData('user', $id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="func/do-edite-user.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
        <div>
            <label for="name">Name: </label>
            <input type="text" name="name" id="name" value="<?= $user['name'] ?>">
            <?php
            if (isset($_SESSION['errors']['name'])) {
                echo $_SESSION['errors']['name'];
            }
            ?>
        </div>
        <br>
        <div>
            <label for="email">Emali: </label>
            <input type="text" name="email" id="email" value="<?= $user['email'] ?>">
            <?php
            if (isset($_SESSION['errors']['email'])) {
                echo $_SESSION['errors']['email'];
            }
            ?>
        </div>
        <br>
        <div>
            <label for="image" style='font-weight: bold;'>Image:</label>
            <input type="file" name='image[]' multiple="">
            <span>Old Image(s): </span>
            <?php
            $images = explode(',', $user['image']);
            // $first_image = $images[0];
            foreach ($images as $image) {
            ?>
                <img src='img/<?= $image ?>' alt="user image" style='height:30px; width:30px; margin-right:20px;'>
            <?php
            }
            ?>
            <?php
            if (isset($_SESSION['errors']['image'])) {
                echo $_SESSION['errors']['image'];
            }
            ?>
        </div>
        <br>
        <br>
        <input type="submit">
        <!-- <input type="reset"> -->
    </form>
</body>

</html>
<?php
unset($_SESSION['errors']);
?>