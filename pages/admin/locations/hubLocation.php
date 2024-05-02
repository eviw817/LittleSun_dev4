<?php
 
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
    //database geeft mij de zaken die er al in staan voor location
    function getLocationName(){
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT id, name FROM locations");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hub Location</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./hubLocation.css">
</head>
<body>
<?php include_once("../../../components/header2.inc.php"); ?>
<main>
    <h1>Hub locations</h1>
    <ul class="locationList">
        <?php foreach(getLocationName() as $location) : ?> 
            <li><a href="location.php?id=<?php echo $location["id"] ?>" class="location_detail"><?php echo $location['name']; ?> 
            </a></li>
        <?php endforeach; ?>
    </ul>
    <!-- <li><a href="location.php">Location 1</a></li>
    <li><a href="#">Location 2</a></li>
    <li><a href="#">Location 3</a></li> -->

    <div class="button">
    <a href="removeLocation.php" class="add_remove_link">Add or remove locations</a>
    </div>
</main>   
</body>
</html>