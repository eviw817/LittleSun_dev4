<?php 
     include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");
     //database geeft mij de zaken die er al in staan voor location
     function getLocationName(){
         $conn = Db::getConnection();
         $statement = $conn->prepare("SELECT id, name FROM locations");
         $statement->execute();
         return $statement->fetchAll(PDO::FETCH_ASSOC);
     }

     function deleteLocation($locationId){
        $conn = Db::getConnection();
        $statement = $conn->prepare("DELETE FROM locations WHERE id = :id");
        $statement->execute([":id" => $locationId]);
        // No need to return anything here as we are just deleting the location
    }
    
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
        $locationId = $_POST["id"];
        deleteLocation($locationId);
        echo "success"; // Return success to indicate successful deletion
        exit(); // Stop further execution
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit location</title>
    <link rel="stylesheet" href="../css/algemeen.css">
</head>
<body>
<h1>Hub location</h1>
    <ul id="locationList">
    <?php foreach(getLocationName() as $key => $location) : ?> 
        <li>
            <a href="location.php?id=<?php echo ($key +1) ?>" class="location_detail"><?php echo $location['name']; ?> </a>
            <button onclick="deleteLocation(<?php echo $location['id']; ?>)">Remove location</button>
        </li>
    <?php endforeach; ?>
    </ul>

    <button onclick="window.location.href='addLocation.php'">Add location</button>

    <script>
    function deleteLocation(locationId) {
        if (confirm("Are you sure you want to delete this location?")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = xhr.responseText;
                    if (response.trim() === "success") {
                        // Remove the item from the list if deletion is successful
                        var listItem = document.querySelector("#locationList li a[href='location.php?id=" + locationId + "']").parentNode;
                        listItem.parentNode.removeChild(listItem);
                    } else {
                        alert("An error occurred while deleting the location.");
                    }
                }
            };
            xhr.send("id=" + locationId);
        }
    }
</script>

    

</body>
</html>