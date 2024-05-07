<?php

    include_once(__DIR__ . DIRECTORY_SEPARATOR . "Db.php");

    class Timetable{
        private string $id;
        private ?string $clock_in_time;
        private ?string $clock_out_time;
        private string $total_hours;
        private string $overtime_hours;
        private string $userId;

        public function __construct($id, $clock_in_time, $clock_out_time, $total_hours, $overtime_hours, $userId){
            $this->id = $id;
            $this->clock_in_time = $clock_in_time;
            $this->clock_out_time = $clock_out_time;
            $this->total_hours = $total_hours;
            $this->overtime_hours = $overtime_hours;
            $this->userId = $userId;
        }

        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of clock_in_time
         */ 
        public function getClock_in_time()
        {
                return $this->clock_in_time;
        }

        /**
         * Set the value of clock_in_time
         *
         * @return  self
         */ 
        public function setClock_in_time($clock_in_time)
        {
                $this->clock_in_time = $clock_in_time;

                return $this;
        }

        /**
         * Get the value of clock_out_time
         */ 
        public function getClock_out_time()
        {
                return $this->clock_out_time;
        }

        /**
         * Set the value of clock_out_time
         *
         * @return  self
         */ 
        public function setClock_out_time($clock_out_time)
        {
                $this->clock_out_time = $clock_out_time;

                return $this;
        }

        /**
         * Get the value of total_hours
         */ 
        public function getTotal_hours()
        {
                return $this->total_hours;
        }

        /**
         * Set the value of total_hours
         *
         * @return  self
         */ 
        public function setTotal_hours($total_hours)
        {
                $this->total_hours = $total_hours;

                return $this;
        }

        /**
         * Get the value of overtime_hours
         */ 
        public function getOvertime_hours()
        {
                return $this->overtime_hours;
        }

        /**
         * Set the value of overtime_hours
         *
         * @return  self
         */ 
        public function setOvertime_hours($overtime_hours)
        {
                $this->overtime_hours = $overtime_hours;

                return $this;
        }

        /**
         * Get the value of userId
         */ 
        public function getUserId()
        {
                return $this->userId;
        }

        /**
         * Set the value of userId
         *
         * @return  self
         */ 
        public function setUserId($userId)
        {
                $this->userId = $userId;

                return $this;
        }

        
        public function clockIn(){
            $conn = Db::getConnection();

            $statement = $conn->prepare("INSERT INTO work_logs (name, description, category, progress, startDate, endDate) VALUES (:name, :description, :category, :progress, :startDate, :endDate);");
            $statement->bindValue(":name", $this->name);
            $statement->bindValue(":description", $this->description);
            $statement->bindValue(":category", $this->category);
            $statement->bindValue(":progress", $this->progress);
            $statement->bindValue(":startDate", $this->startDate);
            $statement->bindValue(":endDate", $this->endDate);


        }
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