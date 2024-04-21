<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");

// Functie om managergegevens op te halen op basis van ID
function getManagerById($managerId){
    $conn = Db::getConnection();
    $statement = $conn->prepare("SELECT u.*, l.name FROM users u LEFT JOIN locations l ON u.location = l.id WHERE u.id = :id AND role = 'manager'");
    $statement->execute([":id" => $managerId]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}

// Functie om alle locatienamen en IDs op te halen
function getLocations(){
    $conn = Db::getConnection();
    $statement = $conn->prepare("SELECT id, name FROM locations");
    $statement->execute();
    $result = $statement->fetchAll();
    return $result;
}

// Controleren of er een manager ID is opgegeven in de URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Managergegevens ophalen
    $manager = getManagerById($id);
    // Controleren of de manager bestaat
    if(!$manager){
        echo "Manager not found";
        die();
    }
} else {
    // Als er geen ID is opgegeven, stop de uitvoering en geef een foutmelding weer
    echo "No manager ID specified";
    die(); 
}

if(isset($_POST['submit'])){
    // Verwerk de formuliargegevens en update de gegevens in de database
    $conn = Db::getConnection();
    $image64 = 'data:image/' . $_FILES['img']['type'] . ';base64,' . base64_encode(file_get_contents($_FILES['img']['tmp_name']));
    if($_POST['location'] = "-1"){
        $location = null;
    } else{
        $location = $_POST["location"];
    }
    $statement = $conn->prepare("UPDATE users SET username = :username, email = :email, role = :role, location = :location, firstName = :firstName, lastName = :lastName, WHERE id = :id");
    $statement->execute([
        ":username" => $_POST['username'],
        ":email" => $_POST['email'],
        ":role" => $_POST['role'],
        ":location" => $location,
        ":firstName" => $_POST['firstName'],
        ":lastName" => $_POST['lastName'],
        ":id" => $id
    ]);

    if(!isset($_POST["password"])){
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
        $statement->execute([
            ":password" => password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]),
            ":id" => $id
        ]);
    }

    if(!isset($_POST["img"])){
        $conn = Db::getConnection();
        $statement = $conn->prepare("UPDATE users SET image = :image WHERE id = :id");
        $statement->execute([
            ":image" => $image64,
            ":id" => $id
        ]);
    }
    
    // Redirect naar de detailpagina met de bijgewerkte gegevens
    header("Location: manager.php?id=$id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit hub manager</title>
    <link rel="stylesheet" href="../../css/algemeen.css">
</head>
<body>
<?php include_once("../header2.inc.php"); ?>
    <div class="form edit_manager">
        <form action="editManager.php?id=<?php echo $manager['id']; ?>" method="post" enctype="multipart/form-data">
            <h2 form__title>Edit hub manager</h2>

            <div class="form__field">
                <label for="username">Username</label>
                <input type="text" name="username" value="<?php echo isset($manager['username']) ? $manager['username'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="email">Email</label>
                <input type="text" name="email" value="<?php echo isset($manager['email']) ? $manager['email'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="new-password">Password</label>
                <input type="password" name="new-password" value="">
            </div>
            <div class="form__field">
                <label for="role">Role</label>
                <input type="text" name="role" value="<?php echo isset($manager['role']) ? $manager['role'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="location">Location</label>
                <select name="location" id="location">
                    <option value="-1">No location</option>
                    <?php foreach(getLocations() as $location) : ?>
                    <option value="<?php echo $location["id"]?>" ><?php echo $location["name"] ?></option>
                    <?php endforeach; ?>
                </select>

            </div>
            <div class="form__field">
                <label for="firstname">Firstname</label>
                <input type="text" name="firstName" value="<?php echo isset($manager['firstName']) ? $manager['firstName'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="lastname">Lastname</label>
                <input type="text" name="lastName" value="<?php echo isset($manager['lastName']) ? $manager['lastName'] : ''; ?>">
            </div>

            <div class="form__field">
                <label for="img">Select image:</label>
                <input type="file" id="img" name="img" accept="image/jpg, png">
            </div>

            <div class="form__field">
                <input type="submit" name="submit" value="Save" class="btn-save">  
            </div>
        </form>
    </div>
</body>
</html>
