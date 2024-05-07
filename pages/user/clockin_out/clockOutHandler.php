<?php
session_start();

include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Timetable.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");

// Controleer of het formulier is ingediend voor klok-uit
if (isset($_POST['clockOutButton'])) {
    // Haal de uitklok-tijd en gebruikers-ID op van het formulier
    $clockOutTime = isset($_POST['clockOutTime']) ? $_POST['clockOutTime'] : null;
    $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
    $username = isset($_POST['username']) ? $_POST['username'] : null;

    try {
        // Maak een nieuwe Timetable instantie met de juiste argumenten
        $timetable = new Timetable(null, $clockOutTime, null, null, $userId, $username);

        // Roep de clockOut() methode aan om de klok-uit tijd te registreren
        $timetable->clockOut();
        header("Location: succesClockout.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: Clock-out button not submitted.";
}
?>
