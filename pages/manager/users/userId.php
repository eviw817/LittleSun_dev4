<?php
 include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
 include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/User.php");

 $user = new User();
 
 if (isset($_GET['id'])) {
     $userId = $_GET['id']; 
     //ophalen van de gebruiker met gegeven id
     $user = $user->getUserById($userId);
     if (!$user) {
         echo "User not found";
         die(); 
     }
 } else {
     echo "No user ID specified";
     die(); 
 }
 

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users details</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./userId.css">


</head>
<body>
<?php include_once("../../../components/header2.inc.php"); ?>
    <h1>User details</h1>
    <p>Username: <?php echo isset($user["username"]) ? $user["username"] : ""; ?></p>
    <p>Firstname: <?php echo isset($user["firstName"]) ? $user["firstName"] : ""; ?></p>
    <p>Lastname: <?php echo isset($user["lastName"]) ? $user["lastName"] : ""; ?></p>
    <p>Email: <?php echo isset($user["email"]) ? $user["email"] : ""; ?></p>
    <p>Location: <?php echo isset($user["name"]) ? $user["name"] : ""; ?></p>
    <div class="image">
        <?php if (isset($user["image"])): ?>
            <p >Profile picture: <img width="70px" src="<?php echo $user["image"]; ?>" alt="Profile Picture"></p>
        <?php endif; ?>
    </div>
    
</body>
</html>
