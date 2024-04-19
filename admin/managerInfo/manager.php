<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");

    function getManagerById($id)
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
    
    
    
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $manager = getManagerById($id);
  } else {
      echo "No location ID specified";
      die();
  }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hub mangers</title>
    <link rel="stylesheet" href="../css/algemeen.css">
</head>
<body>

  <h1>Username: <?php if($manager){echo $manager["username"]; }?></h1>
  <p> Email: <?php if($manager){echo $manager["email"]; } ?></p>
  <p> Password: <?php if($manager){echo $manager["password"]; } ?></p>
  <p> Role: <?php if($manager){echo $manager["role"]; } ?></p>
  <p> Location: <?php if($manager){echo $manager["location"]; } ?></p>
  <p> Firstname: <?php if($manager){echo $manager["firstName"]; } ?></p>
  <p> Lastname: <?php if($manager){echo $manager["lastName"]; } ?></p>

    <button onclick="window.location.href='editManager.php'">Edit</button>
</body>
</html>