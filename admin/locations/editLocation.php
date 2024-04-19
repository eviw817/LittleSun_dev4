<?php 
     include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");
     //database geeft mij de zaken die er al in staan voor location
     function getLocationName(){
         $conn = Db::getConnection();
         $statement = $conn->prepare("SELECT name FROM locations");
         $statement->execute();
         return $statement->fetchAll(PDO::FETCH_ASSOC);
     }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit location</title>
</head>
<body>
<h1>Hub location</h1>
    <ul id="locationList">
    <?php foreach(getLocationName() as $key => $location) : ?> 
        <li><a href="location.php?id=<?php echo $key ?>" class="location_detail"><?php echo $location['name']; ?> 
        </a></li>
    <?php endforeach; ?>
    </ul>

    <button onclick="window.location.href='addLocation.php'">Add location</button>

    <script>
        function removeLocation(element) {
            var listItem = element.parentNode;
            listItem.parentNode.removeChild(listItem);
        }
    </script>
</body>
</html>