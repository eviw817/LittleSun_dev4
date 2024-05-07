<?php

    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../classes/users/User.php");

    class Timetable{
        private string $id;
        private ?string $clock_in_time;
        private ?string $clock_out_time;
        private ?string $total_hours;
        private ?string $overtime_hours;
        private string $userId;
        private string $username;

        public function __construct( $clock_in_time, $clock_out_time, $total_hours, $overtime_hours, $userId, $username){
            $this->clock_in_time = $clock_in_time;
            $this->clock_out_time = $clock_out_time;
            $this->total_hours = $total_hours;
            $this->overtime_hours = $overtime_hours;
            $this->userId = $userId;
            $this->username = $username;

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

         /**
         * Get the value of username
         */ 
        public function getUsername()
        {
                return $this->username;
        }

        /**
         * Set the value of username
         *
         * @return  self
         */ 
        public function setUsername($username)
        {
                $this->username = $username;

                return $this;
        }

        
        public function timeTable(){
            $conn = Db::getConnection();

            $statement = $conn->prepare("INSERT INTO work_logs (id, clock_in_time, clock_out_time, total_hours, overtime_hours, userId, username) VALUES (:id, :clock_in_time, :clock_out_time, :total_hours, :overtime_hours, :userId, :username);");
            $statement->bindValue(":id", $this->id);
            $statement->bindValue(":clock_in_time", $this->clock_in_time);
            $statement->bindValue(":clock_out_time", $this->clock_out_time);
            $statement->bindValue(":total_hours", $this->total_hours);
            $statement->bindValue(":overtime_hours", $this->overtime_hours);
            $statement->bindValue(":userId", $this->userId);
            $statement->bindValue(":username", $this->username);
        }

        // Timetable.php
        public function clockIn() {
                $conn = Db::getConnection();

                if (!empty($this->userId)) {
                    $formattedClockInTime = date("Y-m-d H:i:s", strtotime($this->clock_in_time));
                    $statement = $conn->prepare("INSERT INTO work_logs (clock_in_time, userId, username) VALUES (:clock_in_time, :userId, :username);");
                    $statement->bindValue(":clock_in_time", $formattedClockInTime);
                    $statement->bindValue(":userId", $this->userId);
                    $statement->bindValue(":username", $this->username);
                    $statement->execute();
                } else {
                    throw new InvalidArgumentException('Invalid user ID.');
                }
        }
        
        public function clockOut() {
                $conn = Db::getConnection();
                
                if (!empty($this->userId)) {
                    $clockOutTime = $this->clock_out_time ?? date('Y-m-d H:i:s');
            
                    $formattedClockOutTime = date("Y-m-d H:i:s", strtotime($clockOutTime));
                    $clockInDateTime = $this->clock_in_time ? new DateTime($this->clock_in_time) : null;
                    $clockOutDateTime = new DateTime($clockOutTime);
            
                    if ($clockInDateTime) {
                        $interval = $clockOutDateTime->diff($clockInDateTime);
            
                        $totalHours = $interval->h + ($interval->i / 60);
            
                        //overuren nog veranderen dat af hangt hoelang die persoon moet werken die dag
                        $standardWorkHours = 8;
                        $overtimeHours = max($totalHours - $standardWorkHours, 0);
                    } else {
                      
                        $totalHours = 0;
                        $overtimeHours = 0;
                    }
            
                    // Update the existing row for this user with clock_out_time, total_hours, and overtime_hours
                    $statement = $conn->prepare("UPDATE work_logs SET clock_out_time = :clock_out_time, total_hours = :total_hours, overtime_hours = :overtime_hours WHERE userId = :userId;");
                    $statement->bindValue(":clock_out_time", $formattedClockOutTime);
                    $statement->bindValue(":total_hours", $totalHours);
                    $statement->bindValue(":overtime_hours", $overtimeHours);
                    $statement->bindValue(":userId", $this->userId);
                    $statement->execute();
                } else {
                    throw new InvalidArgumentException('Invalid user ID.');
                }
            }
            
            
        


       
}