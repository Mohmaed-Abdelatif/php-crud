<?php
include("connectDB.php");
$id = $_GET['id'];




$db = new DB();

$db->deleteUser('user', $id);





header("location:../users.php");
?>