<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../classes/Db.php");

function getLocationById()
{
  $conn = Db::getConnection();
  $statement = $conn->prepare("SELECT l.*, u.firstName, u.lastName FROM locations l RIGHT JOIN users u ON l.id = u.location WHERE u.role = 'manager'");
  $statement->execute();
  return $statement->fetchAll(PDO::FETCH_ASSOC);
}


if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  echo "go away";
  die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Location</title>
</head>

<body>
  <h1>Hub: <?php echo getLocationById("name") ?></h1>
  <p> Street: <?php echo getLocationById("street") ?></p>
  <p> StreetNumber: <?php getLocationById("streetNumber") ?></p>
  <p> City: <?php echo getLocationById("city") ?></p>
  <p> Country: <?php echo getLocationById("country") ?></p>
  <p> Postalcode: <?php echo getLocationById("postalCode") ?></p>
  <p> Hub manager: <?php echo getLocationById("firtstName" . ", " . "lastName") ?></p>
  

  <!-- <h1>Location 1</h1>
    <p>Place</p>
    <p>Hub manager 1</p> -->
</body>

</html>