<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");

    $userName = new User($_POST["username"], $_POST["email"], $_POST["password"], $_POST["role"], $_POST["location"], $_POST["firstName"], $_POST["lastName"]);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./userInfo.css">
   
</head>
<body>
<?php include_once("../../../components/header2.inc.php"); ?>
    <h1 class="title">Users</h1>
    <div class="inline">
    <?php foreach($userName->getName()as $user) : ?> 
        <div class="flex">
            <a href="userId.php?id=<?php echo $user['id']; ?>" class="user_detail">
                <p><?php echo $user['firstName'] . " " . $user['lastName'] ; ?></p>
            </a>
            <img width="4.4.375rem" src="<?php echo $user["image"]; ?>"></img>
        </div>
    <?php endforeach; ?>
    </div>
    <div class="button-container">
        <button class="newuser" onclick="window.location.href='addUser.php'">Add new user</button>
    </div>
</body>
</html>