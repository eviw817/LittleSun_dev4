<?php
session_start();

// Include de benodigde bestanden
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Timetable.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");

// Controleer of de gebruiker is ingelogd
if (isset($_SESSION['id'])) {

    $user = User::getUserById($_SESSION['id']);

    date_default_timezone_set('Africa/Lusaka');
    $clockInTime = date("h:i a");
    $clockInDay = date("d - m - Y");

    $userId = $_SESSION['id'];
    $username = $user['username'];
} else {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clock in</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="userClockIn.css">
</head>

<body>
    <?php include_once("../../../components/headerUser.inc.php"); ?>

    <h1>Clock in</h1>
    <p>Day: <?php echo $clockInDay; ?></p>
    <p>Hour: <?php echo $clockInTime; ?></p>
    <p>Welcome, <?php echo $user['username']; ?></p>

    <p>Do you want to clock in for work?</p>
    <form action="userClockInHandler.php" method="post">
        <input type="hidden" name="clockInTime" value="<?php echo $clockInTime; ?>">
        <input type="hidden" name="username" value="<?php echo $username; ?>">
        <input class="clockin" type="submit" name="clockInButton" value="Clock in">
    </form>
</body>

</html>