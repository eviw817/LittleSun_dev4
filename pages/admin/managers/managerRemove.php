<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Admin.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $managerId = $_POST["id"];
    Manager::deleteManager($managerId);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove manager</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./managerRemove.css">
</head>

<body>
    <?php include_once("../../../components/headerAdmin.inc.php"); ?>

    <h1>Hub manager</h1>
    <ul class="inline">
        <?php foreach (Manager::getHubManagerName() as $key => $manager) : ?>
            <li>
                <section class="flex">
                    <div class="manager_detail">
                        <p><?php echo $manager['username']; ?></p>

                        <img src="<?php echo $manager["image"]; ?>"></img>
                    </div>
                    <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete this manager?')">
                        <input type="hidden" name="id" value="<?php echo $manager['id']; ?>">
                        <button type="submit">Remove manager</button>
                    </form>
                </section>
            </li>
        <?php endforeach; ?>
    </ul>

    <a class="button fixed-position" href="managerList.php">Back</a>

</body>

</html>