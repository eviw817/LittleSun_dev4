<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Location.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$manager = Manager::getManagerById($_SESSION['id']);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = User::getUserById($id);
    if (!$user) {
        echo "User not found";
        die();
    }
} else {
    echo "No User ID specified";
    die();
}

if (isset($_POST['save'])) {
    // Haal de huidige rol van de gebruiker op
    $currentUser = User::getUserById($id);

    if (!empty($newPassword)) {
        $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT, $options = ['cost' => 12]);
    } else {
        $hashed_password = $currentUser['password'];
    }

    $updateuser = new User($_POST["username"], $_POST["email"], $hashed_password, $currentUser['role'], ($_POST['location'] == "-1") ? null : $_POST['location'], $_POST["firstName"], $_POST["lastName"]);
    if ($_FILES["img"]["size"]>0) {
        $updateuser -> setImage('data:image/' . $_FILES['img']['type'] . ';base64,' . base64_encode(file_get_contents($_FILES['img']['tmp_name'])));
    } else {
        $image = null;
    }
    $updateuser->setId($id);
    $updateuser->updateInfo();

    header("Location: userInfo.php?id=$id");
    exit();
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit hub manager</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./userEdit.css">
</head>

<body>
    <?php include_once("../../../components/headerUser.inc.php"); ?>
    <section class="form_edit">
        <form action="" method="post" enctype="multipart/form-data">

            <h1>Edit user</h1>

            <div class="form__field">
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?php echo isset($user['username']) ? $user['username'] : ''; ?>">
            </div>

            <div class="form__field">
                <label for="firstname">Firstname:</label>
                <input type="text" name="firstName" value="<?php echo isset($user['firstName']) ? $user['firstName'] : ''; ?>">
            </div>

            <div class="form__field">
                <label for="lastname">Lastname:</label>
                <input type="text" name="lastName" value="<?php echo isset($user['lastName']) ? $user['lastName'] : ''; ?>">
            </div>

            <div class="form__field">
                <label for="email">Email:</label>
                <input type="text" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>">
            </div>

            <div class="form__field">
                <label for="password">Password:</label>
                <input type="password" name="password" value="<?php echo isset($user['password']) ? $user['password'] : ''; ?>">
            </div>
            
            <div class="form__field">
                <label for="img">Select image:</label>
                <input type="file" id="img" name="img" accept="image/jpg, png">
            </div>

            <div class="form__field">
                <input type="submit" name="save" value="Save" class="btn-save">
            </div>
            <a class="button fixed-position" href="userId.php">Back</a>
        </form>
    </section>
</body>

</html>