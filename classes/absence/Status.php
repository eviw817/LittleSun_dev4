<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "Absence.php");

    class Status extends Absence{
        public static function approveRequest($requestId){
            $conn = Db::getConnection();
            $statement = $conn->prepare("UPDATE absence_requests SET approvalStatus='Approved' WHERE id=:requestId");
            $statement->bindValue(':requestId', $requestId, PDO::PARAM_INT);
            if ($statement->execute()) {
                return true;
            } else {
                throw new Exception($conn->error);
            }
        }

        public static function denyRequest($requestId, $reason) {
            $conn = Db::getConnection();
            $statement = $conn->prepare("UPDATE absence_requests SET approvalStatus='Rejected', rejectionReason=:reason WHERE id=:requestId");
            $statement->bindValue(':requestId', $requestId, PDO::PARAM_INT);
            $statement->bindValue(':reason', $reason, PDO::PARAM_STR);  
            if ($statement->execute()) {
                return true;
            } else {
                throw new Exception($conn->error);
            }
        }
    }