<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "/../../../classes/task.php");

// Initialiseer de foutmelding
$error = '';

// Verwerk het formulier alleen als er gegevens zijn ingediend
if(!empty($_POST)){
    try {
        
        // Maak een nieuw Location object en stel de gegevens in
        $location = new Task($_POST['name'], $_POST['description'], $_POST['category'], $_POST['progress'], $_POST['startDate'], $_POST['endDate']);

        // Voeg de locatie toe aan de database
        $location->saveTask();

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
<?php include_once("../../../components/header2.inc.php"); ?>
    <section class="form add_location">
        <?php if(!empty($error)): ?>
            <div class="error">Error: <?php echo $error; ?></div>
        <?php endif; ?> 

        <form action="addLocation.php" method="post">
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
            <div class="form__field">
                <label for="progress">Progress</label>
                <input type="text" name="progress" id="progress">
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
