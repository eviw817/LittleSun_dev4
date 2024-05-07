<?php

    include_once(__DIR__ . DIRECTORY_SEPARATOR . "Db.php");

    class Timetable{
        private string $id;
        private ?string $clock_in_time;
        private ?string $clock_out_time;
        private ?string $clock_in_time;



// Controleer of er op de link "Clock in" is geklikt
if (isset($_GET['clock_in'])) {
    $current_time = date('Y-m-d H:i:s'); // Huidig tijdstip inclusief seconden
    
    // Voorbereidde verklaring om het huidige tijdstip in te voegen in de database
    $statement = $conn->prepare("INSERT INTO work_logs (clock_in_time) VALUES (:clock_in_time)");
    $statement->bindValue(':clock_in_time', $current_time);
    $statement->execute([
        ":clock_in_time" => $current_time,
    ]);


}
    }