<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "Absence.php");

    class Request extends Absence{
        public function newRequest($userId){
            $conn = Db::getConnection();
            $statement = $conn->prepare("INSERT INTO absence_requests (startDateTime, endDateTime, typeOfAbsence, reason, user_id) VALUES (:startDateTime, :endDateTime, :typeOfAbsence, :reason, :user_id)");
            $statement->bindValue(':startDateTime', $this->startDateTime);
            $statement->bindValue(':endDateTime', $this->endDateTime);
            $statement->bindValue(':typeOfAbsence', $this->typeOfAbsence);
            $statement->bindValue(':reason', $this->reason);
            $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
            return $statement->execute();
        }

        public static function getAbsentRequests() {
            $conn = Db::getConnection();
            $statement = $conn->query("SELECT * FROM absence_requests WHERE approvalStatus = 'Pending'");
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }