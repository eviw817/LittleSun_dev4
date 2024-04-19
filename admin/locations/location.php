<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");

function getLocationById($id)
{
    
    $conn = Db::getConnection();
    $statement = $conn->prepare("SELECT l.*, u.firstName, u.lastName FROM locations l LEFT JOIN users u ON l.id = u.location WHERE l.id = :id");
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result;
    } else {
        return false; 
    }
}

function getRole(){
    $conn = Db::getConnection();
    $statement = $conn->prepare("SELECT * FROM users WHERE role = 'manager'");
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result;
    } else {
        return false; 
    }
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $role = $_GET['id'];
    $location = getLocationById($id);
    $roleManager = getRole($role);
} else {
    echo "No location ID specified";
    die();
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location</title>
</head>
<body>
    
    <h1>Hub: <?php if($location){echo $location["name"]; }?></h1>
    <p> Street: <?php if($location){echo $location["street"]; } ?></p>
    <p> Streetnumber: <?php if($location){echo $location["streetNumber"]; } ?></p>
    <p> City: <?php if($location){echo $location["city"]; } ?></p>
    <p> Country: <?php if($location){echo $location["country"]; } ?></p>
    <p> Postalcode: <?php if($location){echo $location["postalCode"]; } ?></p>
    <p> Hub manager: <?php if($roleManager) {if($location){echo $location["firstName"] . " " . $location["lastName"]; } }?></p>
    
</body>
</html>