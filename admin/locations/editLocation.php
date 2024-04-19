<?php 
     include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");
     //database geeft mij de zaken die er al in staan voor location
     function getLocationName(){
         $conn = Db::getConnection();
         $statement = $conn->prepare("DELETE name FROM locations");
         $statement->execute();
         return $statement->fetchAll(PDO::FETCH_ASSOC);
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
            <button onclick="removeLocation(<?php echo $key + 1; ?>)">-</button>
        </li>
    <?php endforeach; ?>
    </ul>

    <button onclick="window.location.href='addLocation.php'">Add location</button>

    <script> //remove a location
        function removeLocation(locationId) {
            if (confirm("Weet u zeker dat u deze locatie wilt verwijderen?")) {
                // Stuur een AJAX-verzoek om de locatie te verwijderen
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "deleteLocation.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Controleer het antwoord van de server
                        var response = xhr.responseText;
                        if (response.trim() === "success") {
                            // Verwijder het item uit de lijst als de verwijdering succesvol is
                            var listItem = document.getElementById("location_" + locationId);
                            listItem.parentNode.removeChild(listItem);
                        } else {
                            alert("Er is een fout opgetreden bij het verwijderen van de locatie.");
                        }
                    }
                };
                xhr.send("id=" + locationId);
            }
        }
    </script>

</body>
</html>