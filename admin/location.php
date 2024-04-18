<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        include_once("data.inc.php");
        $workplace = $locations[$id];
        
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
    <title>Location</title>
</head>
<body>
    <h1><?php echo $workplace['title']?></h1>
    <p><?php echo $workplace['location']?></p>
    <p><?php echo $workplace['manager']?></p>

    <!-- <h1>Location 1</h1>
    <p>Place</p>
    <p>Hub manager 1</p> -->
</body>
</html>