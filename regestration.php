<?php
session_start();

( isset($_GET['name'])? $name = $_GET['name']: $name = '');
( isset($_GET['email'])? $email = $_GET['email']: $email = '');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="./users.php">All Users</a>
    <br>
    <br>
    <form action="func/do-add-user.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="name" style='font-weight: bold;'>Name: </label>
            <input type="text" name="name" id="name" value="<?= $name?>">
            <?php
            if (isset($_SESSION['errors']['name'])) {
                echo $_SESSION['errors']['name'];
            }
            ?>
        </div>
        <br>
        <div>
            <label for="email" style='font-weight: bold;'>Emali: </label>
            <input type="text" name="email" id="email" value="<?= $email?>">
            <?php
            if (isset($_SESSION['errors']['email'])) {
                echo $_SESSION['errors']['email'];
            }
            ?>
        </div>
        <br>
        <div>
            <label for="pass" style='font-weight: bold;'>Password: </label>
            <input type="password" name="pass" id="pass">
            <?php 
            if(isset($_SESSION['errors']['pass'])){
                echo $_SESSION['errors']['pass'];
            }
            ?>
        </div>
        <br>
        <label for="image" style='font-weight: bold;'>Image:</label>
        <input type="file" name='image[]' multiple="">
        <?php 
            if(isset($_SESSION['errors']['image'])){
                echo $_SESSION['errors']['image'];
            }
            ?>
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