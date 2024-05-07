<?php
// clockInHandler.php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Timetable.php");

// Veronderstel dat je relevante gebruikersgegevens hebt, bijvoorbeeld:
$userId = '123';
$currentTime = date('Y-m-d H:i:s'); // Huidige tijd voor clock in

// Maak een nieuw Timetable object en voer de klok in actie uit
$timetable = new Timetable($currentTime, null, null, null, $userId);
$timetable->clockIn();

// Toon een succesbericht
echo "Clock in succesvol!";

// Je kunt hier een redirect toevoegen of een link aanbieden om terug te keren naar een dashboardpagina, bijvoorbeeld:
echo '<br><a href="userDashboard.php">Terug naar dashboard</a>';
?>
