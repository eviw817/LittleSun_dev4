<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");

    function getManagerById($managerId){
        $con = Db::getConnection();
        $statement = $con->prepare("SELECT u.*, l.name FROM users u LEFT JOIN locations l ON u.location = l.id WHERE u.id = :id AND role = 'manager'");
        $statement->execute([":id" => $managerId]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        // Haal de manager op met de opgegeven ID
        $manager = getManagerById($id);
        if (!$manager) {
            echo "Manager not found";
            die(); // Stop verdere uitvoering van de code
        }
    } else {
        // Als er geen ID is, geef dan een foutmelding weer
        echo "No manager ID specified";
        die(); // Stop verdere uitvoering van de code
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hub managers</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./manager.css">
</head>
<body>
<?php include_once("../../../components/header2.inc.php"); ?>
    <h1 class="manager__h1">Manager details</h1>
    <p>Username: <?php echo isset($manager["username"]) ? $manager["username"] : ""; ?></p>
    <p>Email: <?php echo isset($manager["email"]) ? $manager["email"] : ""; ?></p>
    <p>Role: <?php echo isset($manager["role"]) ? $manager["role"] : ""; ?></p>
    <p>Location: <?php echo isset($manager["name"]) ? $manager["name"] : ""; ?></p>
    <p>Firstname: <?php echo isset($manager["firstName"]) ? $manager["firstName"] : ""; ?></p>
    <p>Lastname: <?php echo isset($manager["lastName"]) ? $manager["lastName"] : ""; ?></p>
    <div class="image">
        <?php if (isset($manager["image"])): ?>
            <p >Profile picture: <img width="4.375rem" src="<?php echo $manager["image"]; ?>" alt="Profile Picture"></p>
        <?php endif; ?>
    </div>
    <a class="edit" href="editManager.php?id=<?php echo $manager['id']; ?>">Edit manager</a>

</body>
</html>
