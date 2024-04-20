<?php 
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");

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
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $locationId = $_POST["id"];
    deleteLocation($locationId);
    // Reload the page to reflect the changes
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
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
            <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete this location?')">
            <a href="location.php?id=<?php echo ($key +1) ?>" class="location_detail"><?php echo $location['name']; ?> </a>
                <input type="hidden" name="id" value="<?php echo $location['id']; ?>">
                <button type="submit">Remove location</button>
            </form>
        </li>
    <?php endforeach; ?>
    </ul>

    <button onclick="window.location.href='addLocation.php'">Add location</button>
</body>
</html>


    

</body>
</html>