<?php
session_start();
$errors = [];
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$file_name = $_FILES['image']['name'];
$imgs_names=[];
$imge_exist=$_FILES['image']['error'][0];

if ($imge_exist==0) {
    foreach ($file_name as $key => $value) {

        $img_name = $_FILES['image']["name"][$key];
        $img_tmp = $_FILES['image']['tmp_name'][$key];
        $img_size = $_FILES['image']['size'][$key];

        $img_explode = explode('.', $img_name);
        $img_ext = end($img_explode);
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($img_ext, $allowed_ext)) {
            echo 'imge '; print_r($img_name); echo ' type error';
            exit();
        }

        if ($img_size > 8000000) {
            echo 'imge'; print_r($img_name);echo ' is too large should be less than 8 mega';
            exit();
        }

        $new_img_name = time() . rand(0, 10000) . $img_name;
        array_push($imgs_names, $new_img_name);

        move_uploaded_file($img_tmp, "../img/$new_img_name");
        echo"okokokok";
    }
}else{
    // header("location:../Products.php?action=add&error='image fild cant be impty'");

    $errors['image']='image fild cannot be impty';
}

$new_imgs_names = implode(",", $imgs_names);




$name = $_POST['name'];
$email = $_POST['email'];
$pass = $_POST['pass'];

if (empty($name)) {
    $errors['name'] = 'Name Is Required';
}else if(strlen($name) < 3){
    $errors['name']='name should be more than 3 char';
} else {
    $name = test_input($name);
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $errors['name']  = "Only letters and white space allowed";
    }
}

if (empty($email)) {
    $errors['email']  = "Email Is Required";
} else {
    $email = test_input($email);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email']  = "Invalid email format";
    }
}

if(empty($pass)){
$errors['pass'] = "Password Is Required";
}elseif(strlen($pass) < 6 ){
    $errors['pass'] = "Password must be at least 6 characters long";
}

if(empty($errors)){
    $hashedPassword = password_hash($pass,PASSWORD_DEFAULT);
    include("connectDB.php");
    $data = [
        'name' => $name,
        'email' => $email,
        'password' => $pass, 
        'image' => $new_imgs_names
    ];
    $db = new DB();
    $db->addUser('user', $data);
    header('location:../users.php');
}else{
    $_SESSION['errors'] = $errors;
    header("location:../regestration.php?name=$name&email=$email");
}
