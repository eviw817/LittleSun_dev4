<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "/../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "/../../../classes/Task.php");

// Initialiseer de foutmelding
$error = '';

// Verwerk het formulier alleen als er gegevens zijn ingediend
if(!empty($_POST)){
    try {
        
        // Maak een nieuw Task object en stel de gegevens in
        $task = new Task($_POST['name'], $_POST['description'], $_POST['category'], $_POST['progress'], $_POST['startDate'], $_POST['endDate']);

        // Voeg de task toe aan de database
        $task->saveTask();

        // Redirect naar de gewenste pagina na succesvolle verwerking
        header("Location: taskList.php");
        exit();
    }
    catch(Exception $e){
        // Vang eventuele fouten op en toon ze
        $error = $e->getMessage();
    }
    
}
?>

<!DOCTYPE html>
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
        <?php if(!empty($error)): ?>
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
            <div class="form__field filter">
                <label for="progress">Progress</label>
                <select name="progress" id="progress">
                    <option value="Unassigned">Unassiged</option>
                    <option value="Not Started">Not Started</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Done">Done</option>
                </select>
            </div>
            <div class="form__field">
                <label for="startDate">Start Date</label>
                <input type="text" name="startDate" id="startDate">
            </div>
            <div class="form__field">
                <label for="endDate">End Date</label>
                <input type="text" name="endDate" id="endDate">
            </div>

            <button type="submit" class="btn-save">Save</button>  
        </form>
    </section>
</body>
</html>
