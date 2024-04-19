<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        include_once("data.inc.php");
        $head = $managers[$id];
        
      }
      else{
        echo "go away";
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

    <h1><?php echo $head['name']?></h1>
    <p><?php echo $head['email']?></p>
    <p><?php echo $head['password']?></p>
    <p><?php echo $head['location']?></p>
    <!-- <h1>Hub manager 1</h1>
    <p>Location 1</p>
   
    <p>E-mail</p>
    <p>Password</p> -->

    <button onclick="window.location.href='editManager.php'">Edit</button>
</body>
</html>