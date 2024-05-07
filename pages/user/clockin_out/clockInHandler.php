<?php
session_start();

// Include de benodigde bestanden
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Timetable.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");

// Controleer of het formulier is ingediend voor klok-in
if (isset($_POST['clockInButton'])) {
    // Haal de klok-in tijd en gebruikers-ID op van het formulier
    $clockInTime = isset($_POST['clockInTime']) ? $_POST['clockInTime'] : null;
    $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
    $username = isset($_POST['username']) ? $_POST['username'] : null;

   
    try {
        // Maak een nieuwe Timetable instantie met de juiste argumenten
        $timetable = new Timetable($clockInTime, null, null, null, $userId, $username);

        // Roep de clockIn() methode aan om de klok-in tijd te registreren
        $timetable->clockIn();
        header("Location: succesClockin.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: Clock-in button not submitted.";
}
?>
