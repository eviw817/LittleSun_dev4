<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "/../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "/../../../classes/Task.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "/../../../classes/Admin.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$admin = Admin::getAdmin($_SESSION['id']);

// Initialiseer de foutmelding
$error = '';

// Verwerk het formulier alleen als er gegevens zijn ingediend
if (!empty($_POST)) {
    try {

        // Maak een nieuw Task object en stel de gegevens in
        $task = new Task($_POST['name'], $_POST['description'], $_POST['category']);

        // Voeg de task toe aan de database
        $task->saveTask();

        // Redirect naar de gewenste pagina na succesvolle verwerking
        header("Location: taskList.php");
        exit();
    } catch (Exception $e) {
        // Vang eventuele fouten op en toon ze
        $error = $e->getMessage();
    }
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add task</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./taskAdd_Edit.css">
</head>

<body>
    <?php include_once("../../../components/headerAdmin.inc.php"); ?>
    <section class="form add_tasks">
        <?php if (!empty($error)) : ?>
            <div class="error">Error: <?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <h2 class="form__title">New task</h2>

            <div class="form__field">
                <label for="name">Name</label>
                <input type="text" name="name" id="name">
            </div>
            <div class="form__field">
                <label for="description">Description</label>
                <input type="text" name="description" id="description">
            </div>
            <div class="form__field">
                <label for="category">Category</label>
                <input type="text" name="category" id="category">
            </div>

            <button type="submit" class="btn-save">Save</button>
            <a class="button fixed-position" href="taskList.php">Back</a>
        </form>
    </section>
</body>

</html>