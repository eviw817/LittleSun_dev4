<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");

    if (isset($_SESSION['id'])) {
        // Veronderstel dat de locatie-ID wordt opgeslagen in de sessie onder de sleutel 'location_id'
        $manager = Manager::getManagerById($_SESSION['id']);
        $locationId = $manager['location'];
        $users = User::getUsersByLocation($locationId); // Gebruik de juiste methode om gebruikers op te halen
    
    } else {
        header("Location: login.php");
        exit();
    }



?><!DOCTYPE html>
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
    <?php include_once("../../../components/headerManager.inc.php"); ?>
    <main>
        <h1 class="title">Users</h1>
        <section class="inline">
            <?php if ($users) : ?>
                
                <?php foreach ($users as $user) : ?>
                    <div class="flex">
                        <a href="userId.php?id=<?php echo $user['id']; ?>" class="user_detail">
                            <p><?php echo $user["username"]; ?></p>
                            <img src="<?php echo $user["image"]; ?>" alt="<?php echo $user['firstName'] . " " . $user['lastName']; ?>">
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No users found for this location.</p>
            <?php endif; ?>
        </section>
        <div class="button-container">
            <a class="newuser" href="userAdd.php">Add new user</a>
        </div>

    </main>
</body>

</html>