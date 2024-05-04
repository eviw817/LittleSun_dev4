<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/location.php");

// Controleren of er een locatie ID is opgegeven in de URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Locatiegegevens ophalen
    $location = Location::getLocationById($id);
    // Controleren of de locatie bestaat
    if(!$location){
        echo "Location not found";
        die();
    }
} else {
    // Als er geen ID is opgegeven, stop de uitvoering en geef een foutmelding weer
    echo "No location ID specified";
    die(); 
}

if(isset($_POST['submit'])){
    // Verwerk de formuliargegevens en update de gegevens in de database
    $location = new Location($_POST["name"], $_POST["street"], $_POST["streetNumber"], $_POST["city"], $_POST["country"], $_POST["postalCode"]);
    $location->setId($id);
    $location->updateLocation();
    
    // Redirect naar de detailpagina met de bijgewerkte gegevens
    header("Location: locationInfo.php?id=$id");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit hub location</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./LocationAdd_Edit.css">
</head>
<body>
    <?php include_once("../../../components/header2.inc.php"); ?>
    <div class="form edit_location">
    <form action="locationEdit.php?id=<?php echo $location['id']; ?>" method="post">

            <h2 class="form__title">Edit hub location</h2>

            <div class="form__field">
                <label for="name">Name</label>
                <input type="text" name="name" value="<?php echo isset($location['name']) ? $location['name'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="street">Street</label>
                <input type="text" name="street" value="<?php echo isset($location['street']) ? $location['street'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="streetNumber">Street Number</label>
                <input type="text" name="streetNumber" value="<?php echo isset($location['streetNumber']) ? $location['streetNumber'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="city">City</label>
                <input type="text" name="city" value="<?php echo isset($location['city']) ? $location['city'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="country">Country</label>
                <input type="text" name="country" value="<?php echo isset($location['country']) ? $location['country'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="postalCode">Postal Code</label>
                <input type="text" name="postalCode" value="<?php echo isset($location['postalCode']) ? $location['postalCode'] : ''; ?>">
            </div>

            <div class="form__field">
                <input type="submit" name="submit" value="Save" class="btn-save">  
            </div>
        </form>
    </div>
</body>
</html>
