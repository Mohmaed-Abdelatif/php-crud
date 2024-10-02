<?php
include("connectDB.php");
$db = new DB();
session_start();
$id = $_GET['id'];

$errors = [];
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



$name = $_POST['name'];
$email = $_POST['email'];

if (empty($name)) {
    $errors['name'] = 'Name Is Required';
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

$updateData = [
    'name' => $name,
    'email' => $email,
];

if(empty($errors)){
    if ($_FILES['image']['error'][0] === 0) {
        $file_name = $_FILES['image']['name'];
        $imgs_names = [];
        if (!empty($file_name)) {
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
            }
        }
        $new_imgs_names = implode(",", $imgs_names);
    
        //delet old from directory(pc,server)
        $result = $conn->query("SELECT image FROM user WHERE id=$id");
        $row = $result->fetch_assoc();
        $img_name = $row["image"];
        $images = explode(',', $img_name);
        if (count($images) > 1) {
            for ($i = 0; $i < count($images); $i++){
                $img_path = "../img/" . $images[ $i ];
                print_r($img_path);
                if (file_exists($img_path)) {
                    unlink($img_path);
                    echo "Product and image deleted successfully.";
                } else {
                    echo "Product deleted, but image not found.";
                }
            }
        } else {
            $img_path = "../img/" . $img_name;
            print_r($img_path);
            if (file_exists($img_path)) {
                unlink($img_path);
                echo "image deleted successfully.";
            } else {
                echo "image not found.";
            }
        }
        $updateData['image'] = $new_imgs_names;
        // $update = "UPDATE user Set name='$name',email='$email',image='$new_imgs_names' where id=$id";
        $db->updateUser('user', $updateData, $id);
    } else {
        $db->updateUser('user', $updateData, $id);
    }

    header('location:../users.php');
}else{
    $_SESSION['errors'] = $errors;
    header("location:../edite.php?id=$id");
}
