<?php

    include_once(__DIR__ . DIRECTORY_SEPARATOR . "Db.php");

    class Timetable{
        private string $id;
        private ?string $clock_in_time;
        private ?string $clock_out_time;
        private ?string $total_hours;
        private ?string $overtime_hours;
        private string $userId;

        public function __construct( $clock_in_time, $clock_out_time, $total_hours, $overtime_hours, $userId){
            $this->clock_in_time = $clock_in_time;
            $this->clock_out_time = $clock_out_time;
            $this->total_hours = $total_hours;
            $this->overtime_hours = $overtime_hours;
            $this->userId = $userId;

            return $this;
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
                // Parseer de tijd naar een DateTime-object
            $dateTime = new DateTime($this->clock_in_time);

            // Haal het uur van de dag op (in 24-uursformaat)
            $hourOfDay = $dateTime->format('H, m, s'); // 'H' geeft het uur in 24-uursformaat terug

            return $hourOfDay;
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

        
        public function timeTable(){
            $conn = Db::getConnection();

            $statement = $conn->prepare("INSERT INTO work_logs (id, clock_in_time, clock_out_time, total_hours, overtime_hours, userId) VALUES (:id, :clock_in_time, :clock_out_time, :total_hours, :overtime_hours, :userId);");
            $statement->bindValue(":id", $this->id);
            $statement->bindValue(":clock_in_time", $this->clock_in_time);
            $statement->bindValue(":clock_out_time", $this->clock_out_time);
            $statement->bindValue(":total_hours", $this->total_hours);
            $statement->bindValue(":overtime_hours", $this->overtime_hours);
            $statement->bindValue(":userId", $this->userId);
        }

        // Timetable.php
        public function clockIn(){
            $conn = Db::getConnection();

            // Voorbereiden van de SQL-query om clock in te voegen
            $statement = $conn->prepare("INSERT INTO work_logs (clock_in_time, userId) VALUES (:clock_in_time, :userId);");
            $statement->bindValue(":clock_in_time", $this->clock_in_time);
            $statement->bindValue(":userId", $this->userId);

            // Uitvoeren van de query
            $statement->execute();
        }


}