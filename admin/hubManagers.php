<?php
    include_once(__DIR__ . "/../classes/HubManagers.php"); 

    if(!empty($_POST)){
        try {
          $manager1 = new HubManagers();
          $manager1->setFirstname($_POST['firstname']);
          $manager1->setLastname($_POST['lastname']);
          
         
        }
        catch(Exception $e){
          //$error = $e->getMessage();
          
        }
    }


    include_once("data.inc.php");

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hub mangers</title>
</head>
<body>
    <h1>Hub managers</h1>
    <?php foreach($managers as $key => $manager) : ?> 
        <a href="manager.php?id=<?php echo $key ?>" class="manager_detail"> <p><?php echo $manager['name']; ?></p> 
        </a>
    <?php endforeach; ?>
    <!-- <li><a href="#">Hub manager 1</a></li>
    <li><a href="#">Hub manager 2</a></li>
    <li><a href="#">Hub manager 3</a></li> -->

    <button onclick="window.location.href='addManager.php'">Add new hub manager</button>
</body>
</html>