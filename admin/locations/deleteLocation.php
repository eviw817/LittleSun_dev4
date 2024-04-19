<?php
if(isset($_POST['id'])) {
    $locationId = $_POST['id'];
    
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");
    $conn = Db::getConnection();
    
    $statement = $conn->prepare("DELETE FROM locations WHERE id = :id");
    $statement->bindParam(':id', $locationId);
    $result = $statement->execute();

    if ($result) {
        echo "success";
    } else {
        echo "error: " . $statement->errorInfo()[2]; // Geeft de specifieke foutmelding terug
    }
} else {
    echo "error: Geen locatie-id ontvangen";
}
?>
