<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/absence/Request.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/absence/Status.php");

$successMsg = null;
$errorMsg = null;

// Goedkeuren of afwijzen van verlofaanvragen
if (!empty($_POST)) {
    if(isset($_POST["approve"])) {
        try {
            Status::approveRequest($_POST["requestId"]);
            $successMsg = "Absent request approved";
        } catch(Exception $e){
            $errorMsg = "An error occured: " . $e->getMessage();
        }
    } elseif(isset($_POST['reject'])) {
        // Zorg ervoor dat er een reden wordt ingevuld bij afwijzing
        if(empty($reason)) {
            $_SESSION['error_message'] = "Please provide a reason for rejection.";
        } else {
            try {
                Status::denyRequest($_POST['requestId'], $_POST['reason_' . $_POST['requestId']]);
                $successMsg = "Absence request rejected successfully.";
            } catch(Exception $e){
                $errorMsg = "An error occured: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="../../reset.css">
    <link rel="stylesheet" href="../../shared.css">
    <link rel="stylesheet" href="./approveDecline.css">
</head>
<body>
<?php include_once("../../components/headerUser.inc.php"); ?>
<div class="-dashboard">
    <h1>Manager Dashboard</h1>

    <h2>Absence Requests:</h2>
    <div class='success-message'><?php if (isset($successMsg)) { echo $successMsg; } ?></div>
    <div class='error-message'><?php if(isset($errorMsg)) { echo $errorMsg; } ?></div>

    <?php 
            $results = Request::getAbsentRequests();
            if($results): ?>
        <table>
        <tr>
                <th>Start Date & Time</th>
                <th>End Date & Time</th>
                <th>Type of Absence</th>
                <th>Reason</th>
                <th>Action</th>
            </tr>
            <?php foreach($results as $request) : ?>
            <tr>
                <td><?php echo $request["startDateTime"] ?></td>
                <td><?php echo $request["endDateTime"] ?></td>
                <td><?php echo $request["typeOfAbsence"] ?></td>
                <td><?php echo $request["reason"] ?></td>
                <td>
                    <form method='post' action=''>
                        <input type='hidden' name='requestId' value="<?php echo $request["id"] ?>">
                        <input type='text' name='<?php echo "reason" . $request["id"] ?>' placeholder='Reason for rejection'>
                        <button type='submit' name='approve'>Approve</button>
                        <button type='submit' name='reject'>Reject</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
            <p>No absence requests</p>
    <?php endif; ?>
</div>
</body>
</html>
