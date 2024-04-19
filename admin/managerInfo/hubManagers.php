<?php
   
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");
    //database geeft mij de zaken die er al in staan voor location
    function getHubManagerName(){
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT username FROM users WHERE role = 'manager'");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hub managers</title>
</head>
<body>
    <h1>Hub managers</h1>
    <?php foreach(getHubManagerName() as $key => $manager) : ?> 
        <a href="manager.php?id=<?php echo $key ?>" class="manager_detail"> <p><?php echo $manager['username']; ?></p> 
        </a>
    <?php endforeach; ?>
    <!-- <li><a href="#">Hub manager 1</a></li>
    <li><a href="#">Hub manager 2</a></li>
    <li><a href="#">Hub manager 3</a></li> -->

    <button onclick="window.location.href='addManager.php'">Add new hub manager</button>
</body>
</html>