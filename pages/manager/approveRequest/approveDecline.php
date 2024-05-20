<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/absence/Request.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/absence/Status.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");

$successMsg = null;
$errorMsg = null;

$managerInfo = Manager::getManagerById($_SESSION["id"]);
$requests = Request::getAbsentRequests($managerInfo['location']);

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
        $requestId = $_POST["requestId"];
        $reasonKey = 'reason_' . $requestId;
        if(empty($_POST[$reasonKey])) {
            $errorMsg = "Please provide a reason for rejection.";
        } else {
            $reason = $_POST[$reasonKey];
            try {
                Status::denyRequest($requestId, $reason);
                $successMsg = "Absence request rejected successfully.";
            } catch(Exception $e){
                $errorMsg = "An error occurred: " . $e->getMessage();
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
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./approveDecline.css">
</head>
<body>
<?php include_once("../../../components/headerManager.inc.php"); ?>
<div class="-dashboard">
    <h1>Absence request</h1>
    <div class='success-message'><?php if (isset($successMsg)) { echo $successMsg; } ?></div>
    <div class='error-message'><?php if(isset($errorMsg)) { echo $errorMsg; } ?></div>

    <h4><?php echo $managerInfo['name']; ?></h4>

    <?php 
            $results = Request::getAbsentRequests($managerInfo['location']);
            if($results): ?>
        <table>
        <tr>
                <th>User</th>
                <th>Start Date & Time</th>
                <th>End Date & Time</th>
                <th>Type of Absence</th>
                <th>Reason</th>
                <th>Action</th>
        </tr>
            <?php foreach($results as $request) : ?>
            <tr class="colomn">
                <td><?php echo $request["username"] ?></td>
                <td><?php echo $request["startDateTime"] ?></td>
                <td><?php echo $request["endDateTime"] ?></td>
                <td><?php echo $request["typeOfAbsence"] ?></td>
                <td><?php echo $request["reason"] ?></td>
                <td>
                <form method='post' action=''>
                    <input type='hidden' name='requestId' value="<?php echo $request["id"] ?>">
                    <?php if(isset($_POST['reject']) && $_POST['requestId'] == $request["id"]) : ?>
                        <input type='text' name='reason_<?php echo $request["id"] ?>' placeholder='Reason for rejection' required>
                    <?php endif; ?>
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
