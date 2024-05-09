<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "Absence.php");

    class Request extends Absence{
        public function newRequest(){
            $conn = Db::getConnection();
            $statement = $conn->prepare("INSERT INTO absence_requests (startDateTime, endDateTime, typeOfAbsence, reason) VALUES (:startDateTime, :endDateTime, :typeOfAbsence, :reason)");
            $statement->bindValue(':startDateTime', $this->startDateTime);
            $statement->bindValue(':endDateTime', $this->endDateTime);
            $statement->bindValue(':typeOfAbsence', $this->typeOfAbsence);
            $statement->bindValue(':reason', $this->reason);
        }

        public static function getAbsentRequests() {
            $conn = Db::getConnection();
            $statement = $conn->query("SELECT * FROM absence_requests WHERE approvalStatus = 'Pending'");
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }