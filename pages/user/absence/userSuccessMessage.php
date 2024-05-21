<?php

$resultMessage = "Absence request submitted successfully.";

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./userSuccessMessage.css">
    <title>Success</title>
</head>

<body>
    <?php include_once("../../../components/headerUser.inc.php"); ?>
    <h1>Success</h1>
    <p><?php echo $resultMessage; ?></p>
    <a class="back" href="../../dashboard/userDashboard.php">Back to dashboard</a>
</body>

</html>