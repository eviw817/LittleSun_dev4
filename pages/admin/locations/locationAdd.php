<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "/../../../classes/location.php");

// Initialiseer de foutmelding
$error = '';

// Verwerk het formulier alleen als er gegevens zijn ingediend
if(!empty($_POST)){
    try {
        
        // Maak een nieuw Location object en stel de gegevens in
        $location = new Location($_POST['name'], $_POST['street'], $_POST['streetNumber'], $_POST['city'], $_POST['country'], $_POST['postalCode']);

        // Voeg de locatie toe aan de database
        $location->saveLocation();

        // Redirect naar de gewenste pagina na succesvolle verwerking
        header("Location: locationList.php");
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
    <title>Add location</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./locationAdd_Edit.css">
</head>
<body>
<?php include_once("../../../components/header2.inc.php"); ?>
    <section class="form add_location">
        <?php if(!empty($error)): ?>
            <div class="error">Error: <?php echo $error; ?></div>
        <?php endif; ?> 

        <form action="locationAdd.php" method="post">
            <h2 class="form__title">New location</h2>

            <div class="form__field">
                <label for="name">Name</label>
                <input type="text" name="name" id="name">
            </div>
            <div class="form__field">
                <label for="street">Street</label>
                <input type="text" name="street" id="street">
            </div>
            <div class="form__field">
                <label for="streetnumber">Streetnumber</label>
                <input type="text" name="streetNumber" id="streetNumber">
            </div>
            <div class="form__field">
                <label for="city">City</label>
                <input type="text" name="city" id="city">
            </div>
            <div class="form__field">
                <label for="country">Country</label>
                <input type="text" name="country" id="country">
            </div>
            <div class="form__field">
                <label for="postalcode">Postalcode</label>
                <input type="text" name="postalCode" id="postalCode">
            </div>

            <button type="submit" class="btn-save">Save</button>  
        </form>
    </section>
</body>
</html>
