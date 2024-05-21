<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$manager = Manager::getManagerById($_SESSION['id']);

if (!empty($_POST)) {
    try {
        $username = $_POST["firstName"] . '.' . $_POST["lastName"];
        $user = new User($username, $_POST["email"], $_POST["password"], "user", $_POST["location"], $_POST["firstName"], $_POST["lastName"]);

        if (isset($_POST["img"])) {
            $user->setImage('data:image/' . $_FILES['img']['type'] . ';base64,' . base64_encode(file_get_contents($_FILES['img']['tmp_name'])));
        }

        $user->newUser();

        header("Location: userInfo.php");
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add user</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./userAdd.css">

</head>

<body>
    <?php include_once("../../../components/headerManager.inc.php"); ?>
    <?php if (isset($error)) : ?>
        <div class="text-red-500">Error: <?php echo $error; ?></div>
    <?php endif; ?>

    <div class="form new_user">
        <form action="userAdd.php" method="post" enctype="multipart/form-data">
            <h2 form__title>New user</h2>
            <div class="form__field">
                <label for="firstName">Firstname:</label>
                <input type="text" name="firstName" id="firstName">
            </div>

            <div class="form__field">
                <label for="lastName">Lastname:</label>
                <input type="text" name="lastName" id="lastName">
            </div>

            <div class="form__field">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email">
            </div>

            <div class="form__field">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
            </div>

            <div class="form__field">
                <label for="img">Select image:</label>
                <input type="file" id="img" name="img" accept="image/jpg, png">
            </div>

            <div class="form__field">
                <input type="submit" value="Save" class="btn-add">
            </div>
            <a class="button fixed-position" href="userInfo.php">Back</a>
        </form>
    </div>
</body>

</html>