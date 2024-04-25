<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/User.php");

    $userName = new User();
 
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="../../css/general.css">
   
</head>
<body>
<?php include_once("../../header.inc.php"); ?>
    <h1 class="title">Users</h1>
    <div class="inline">
    <?php foreach($userName->getName()as $user) : ?> 
        <div class="flex">
            <a href="userId.php?id=<?php echo $user['id']; ?>" class="user_detail">
                <p><?php echo $user['firstName'] . " " . $user['lastName'] ; ?></p>
            </a>
            <img width="70px" src="<?php echo $user["image"]; ?>"></img>
        </div>
    <?php endforeach; ?>
    </div>
    <div class="button-container">
        <button class="newuser" onclick="window.location.href='addUser.php'">Add new user</button>
    </div>
</body>
</html>