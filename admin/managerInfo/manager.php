<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");

    function getManagerById($managerId){
        $con = Db::getConnection();
        $statement = $con->prepare("SELECT l.*, u.username, u.email, u.password, u.role, u.firstName, u.lastName FROM locations l LEFT JOIN users u ON l.id = u.location WHERE l.id = :id AND role = 'manager'");
        $statement->execute([":id" => $managerId]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if(!$result){
            return null;
        } else {
            return $result;
        }
        
    }
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        // Haal de manager op met de opgegeven ID
        $manager = getManagerById($id);
    } else {
        // Als er geen ID is, geef dan een foutmelding weer
        echo "No location ID specified";
        die(); // Stop verdere uitvoering van de code
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

<h1>Username: <?php echo isset($manager["username"]) ? $manager["username"] : ""; ?></h1>
<p>Email: <?php echo isset($manager["email"]) ? $manager["email"] : ""; ?></p>
<p>Password: <?php echo isset($manager["password"]) ? $manager["password"] : ""; ?></p>
<p>Role: <?php echo isset($manager["role"]) ? $manager["role"] : ""; ?></p>
<p>Location: <?php echo isset($manager["location"]) ? $manager["location"] : ""; ?></p>
<p>Firstname: <?php echo isset($manager["firstName"]) ? $manager["firstName"] : ""; ?></p>
<p>Lastname: <?php echo isset($manager["lastName"]) ? $manager["lastName"] : ""; ?></p>


    <button onclick="window.location.href='editManager.php'">Edit</button>
</body>
</html>