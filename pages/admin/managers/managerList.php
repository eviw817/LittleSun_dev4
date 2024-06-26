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

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hub managers</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./managerList.css">
</head>

<body>
    <?php include_once("../../../components/headerAdmin.inc.php"); ?>
    <h1 class="title">Hub managers</h1>
    <section>
        <div class="inline">
            <?php foreach (Manager::getHubManagerName() as $manager) : ?>
                <div class="flex">
                    <a href="managerInfo.php?id=<?php echo $manager['id']; ?>" class="manager_detail">
                        <p><?php echo $manager['username']; ?></p>

                        <img src="<?php echo $manager["image"]; ?>"></img>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <a class="button fixed-position" href="managerAdd.php">Add new hub manager</a>
        <a class="button fixed-position" href="managerRemove.php">Remove managers</a>
    </section>
</body>

</html>