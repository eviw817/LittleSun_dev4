<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Task.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$manager = Manager::getManagerById($_SESSION['id']);

$error = null;
$task = Task::getTaskById($_GET["id"]);
$users = User::getAllUsers();
if (!isset($task)) {
    $error = "The asked task doesn't exist";
}

if (isset($_POST['submit'])) {
    // Verwerk de formuliergegevens en update de gegevens in de database
    $updatedTask = new Task($task["name"], $task["description"], $task["category"], $task["progress"], $task["startDate"], $task["endDate"]);
    $updatedTask->setId($_GET["id"]);
    $updatedTask->AssignUserToTask($_POST["user"]);

    // Redirect naar de detailpagina met de bijgewerkte gegevens
    header("Location: managerTaskInfo.php?id=" . $_GET["id"]);
    exit();
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Information</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./managerTaskAssign.css">
</head>

<body>
    <?php include_once("../../../components/headerManager.inc.php"); ?>
    <main>
        <form method="post" action="">

            <h1>Task: <?php if ($task) {
                            echo $task["name"];
                        } ?></h1>
            <section>
                <p> Description: <?php if ($task) {
                                        echo $task["description"];
                                    } ?></p>
                <p> Category: <?php if ($task) {
                                    echo $task["category"];
                                } ?></p>
                <!-- <p> Progress: <?php if ($task) {
                                        echo $task["progress"];
                                    } ?></p>
        <p> Start Date: <?php if ($task) {
                            echo $task["startDate"];
                        } ?></p>
        <p> End Date: <?php if ($task) {
                            echo $task["endDate"];
                        } ?></p> -->
                <div class="form__field dropdown">
                    <label for="user">Assign user:</label>
                    <select name="user" id="user">
                        <?php foreach ($users as $user) : ?>
                            <option value="<?php echo $user['id'] ?>"><?php echo $user['username'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <input type="submit" name="submit" value="Confirm Edit" class="button fixed.position">
            </section>
        </form>
    </main>

</body>

</html>