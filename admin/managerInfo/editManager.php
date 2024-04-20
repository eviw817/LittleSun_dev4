<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");

// Functie om managergegevens op te halen op basis van ID
function getManagerById($managerId){
    $con = Db::getConnection();
    $statement = $con->prepare("SELECT l.*, u.id, u.username, u.email, u.location, u.password, u.role, u.firstName, u.lastName FROM locations l LEFT JOIN users u ON l.id = u.location WHERE u.id = :id AND role = 'manager'");
    $statement->execute([":id" => $managerId]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
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

// Controleren of het formulier is ingediend om de manager bij te werken
if(isset($_POST['submit'])){
    // Hier kun je de code toevoegen om de managergegevens bij te werken in de database
    // Verwijzing naar de juiste script om de bewerking af te handelen
    // Redirect naar een andere pagina na het bijwerken
    header("Location: manager.php?id=$id"); // bijvoorbeeld manager.php
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit hub manager</title>
    <link rel="stylesheet" href="../css/algemeen.css">
</head>
<body>
    <div class="form edit_manager">
        <form action="editManager.php?id=<?php echo $manager['id']; ?>" method="post">
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
                <label for="password">Password</label>
                <input type="password" name="password" value="<?php echo isset($manager['password']) ? $manager['password'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="role">Role</label>
                <input type="text" name="role" value="<?php echo isset($manager['role']) ? $manager['role'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="location">Location</label>
                <input type="text" name="location" value="<?php echo isset($manager['location']) ? $manager['location'] : ''; ?>">
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
                <input type="submit" name="submit" value="Save" class="btn-save">  
            </div>
        </form>
    </div>
</body>
</html>
