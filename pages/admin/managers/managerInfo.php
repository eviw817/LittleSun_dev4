<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Admin.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$admin = Admin::getAdmin($_SESSION['id']);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $manager = Manager::getManagerById($id);
    if (!$manager) {
        echo "Manager not found";
        die();
    }
} else {

    echo "No manager ID specified";
    die();
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hub managers</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./managerInfo.css">
</head>

<body>
    <?php include_once("../../../components/headerAdmin.inc.php"); ?>
    <div class="main">
        <h1 class="manager__h1">Manager details</h1>
        <p>Username: <?php echo isset($manager["username"]) ? $manager["username"] : ""; ?></p>
        <p>Email: <?php echo isset($manager["email"]) ? $manager["email"] : ""; ?></p>
        <p>Role: <?php echo isset($manager["role"]) ? $manager["role"] : ""; ?></p>
        <p>Location: <?php echo isset($manager["name"]) ? $manager["name"] : ""; ?></p>
        <p>Firstname: <?php echo isset($manager["firstName"]) ? $manager["firstName"] : ""; ?></p>
        <p>Lastname: <?php echo isset($manager["lastName"]) ? $manager["lastName"] : ""; ?></p>
        <p>Profile picture: </p>
        <div class="image">
            <?php if (isset($manager["image"])) : ?>
                <img width="4.375rem" src="<?php echo $manager["image"]; ?>" alt="Profile Picture">
            <?php endif; ?>
        </div>
        <div class="edit-link">
            <a class="edit" href="managerEdit.php?id=<?php echo $manager['id']; ?>">Edit manager</a>
        </div>
        <div class="edit-link">
            <a class="edit" href="managerList.php">Back</a>
        </div>

    </div>

</body>

</html>