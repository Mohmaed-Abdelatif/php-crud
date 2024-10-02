<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        td {
            text-align: center;
        }

        .controls a {
            margin: 10px;
        }
    </style>
</head>

<body>
    <a href="./regestration.php">Add User</a>
    <br><br>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Image</th>
                <th>Controls</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include the DB class
            require("./func/connectDB.php");

            // Create a new DB instance and get all users
            $db = new DB();
            $users = $db->getAllData('user'); // Assuming your table is named 'user'

            // Check if any users are returned
            if ($users) {
                foreach ($users as $userRow) {
            ?>
                    <tr>
                        <td><?= $userRow['id'] ?></td>
                        <td><?= $userRow['name'] ?></td>
                        <td><?= $userRow['email'] ?></td>
                        <td>
                            <?php
                            // Handle the image data
                            $images = explode(',', $userRow['image']);
                            $first_image = $images[0];
                            ?>
                            <img src='./img/<?= $first_image ?>' alt="user image" style='height:60px; width:60px;'>
                        </td>
                        <td class="controls">
                            <a href="./view.php?id=<?= $userRow['id'] ?>">View</a>
                            <a href="./edite.php?id=<?= $userRow['id'] ?>">Edite</a>
                            <a href="./func/do-delete-user.php?id=<?= $userRow['id'] ?>">Delete</a>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='5'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>
