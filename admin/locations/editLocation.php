<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");

// Functie om managergegevens op te halen op basis van ID
function getLocationById($locationId){
    $con = Db::getConnection();
    $statement = $con->prepare("SELECT * FROM locations" );
    $statement->execute([":id" => $locationId]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}

// Controleren of er een manager ID is opgegeven in de URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Managergegevens ophalen
    $location = getLocationById($id);
    // Controleren of de manager bestaat
    if(!$location){
        echo "location not found";
        die();
    }
} else {
    // Als er geen ID is opgegeven, stop de uitvoering en geef een foutmelding weer
    echo "No location ID specified";
    die(); 
}

if(isset($_POST['submit'])){
    // Verwerk de formuliargegevens en update de gegevens in de database
    $con = Db::getConnection();
    $statement = $con->prepare("UPDATE locations SET name = :name, street = :street, streetNumber = :streetNumber, city = :city, country = :country, postalCode = :postalCode WHERE id = :id");
    $statement->execute([
        ":name" => $_POST['name'],
        ":street" => $_POST['street'],
        ":streetNumber" => $_POST['streetNumber'],
        ":city" => $_POST['city'],
        ":country" => $_POST['country'],
        ":postalCode" => $_POST['postalCode'],
        ":id" => $id
    ]);
    
    // Redirect naar de detailpagina met de bijgewerkte gegevens
    header("Location: location.php?id=$id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit hub location</title>
    <link rel="stylesheet" href="../css/algemeen.css">
</head>
<body>
    <div class="form edit_location">
        <form action="editManager.php?id=<?php echo $manager['id']; ?>" method="post">
            <h2 form__title>Edit hub manager</h2>

            <div class="form__field">
                <label for="name">Name</label>
                <input type="text" name="name" value="<?php echo isset($location['name']) ? $location['name'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="street">Street</label>
                <input type="text" name="street" value="<?php echo isset($location['street']) ? $location['street'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="streetNumber">streetNumber</label>
                <input type="streetNumber" name="streetNumber" value="<?php echo isset($location['streetNumber']) ? $location['streetNumber'] : ''; ?>">
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
                <label for="postalCode">PostalCode</label>
                <input type="text" name="postalCode" value="<?php echo isset($location['postalCode']) ? $location['postalCode'] : ''; ?>">
            </div>

            <div class="form__field">
                <input type="submit" name="submit" value="Save" class="btn-save">  
            </div>
        </form>
    </div>
</body>
</html>
