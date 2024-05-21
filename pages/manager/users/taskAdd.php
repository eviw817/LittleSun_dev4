<?php
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
$task = null;

// Controleren of er een taak-ID is doorgegeven via de URL
if (isset($_GET["taskId"])) {
    // Taakdetails ophalen op basis van het ID
    $taskId = $_GET["taskId"];
    $task = Task::getTaskById($taskId);

    if (!$task) {
        $error = "Task not found";
    }
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Information</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./taskAdd.css">
</head>

<body>
    <?php include_once("../../../components/headerManager.inc.php"); ?>
    <main>
        <h1>Tasks</h1>
        <section>
            <ul class="taskList">
                <?php foreach (Task::getTasks() as $task) : ?>
                    <li>
                        <!-- Link naar dezelfde pagina met taskId als URL-parameter -->
                        <a href="?taskId=<?php echo $task["id"]; ?>"><?php echo $task['name']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <!-- Details van de taak -->
        <?php if ($task) : ?>
            <section class="taskDetailsSection">
                <div class="taskDetails">
                    <h2>Task Details</h2>
                    <p>Name: <?php echo $task['name']; ?></p>
                    <p>Description: <?php echo $task['description']; ?></p>
                    <!-- Voeg andere details van de taak toe zoals nodig -->
                </div>
            </section>
        <?php elseif ($error) : ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
    </main>
</body>

</html>