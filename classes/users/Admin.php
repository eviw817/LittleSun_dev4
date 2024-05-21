<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "ParentUser.php");

class Admin extends ParentUser
{
    public static function getAdmin($adminId)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM users WHERE role = 'admin' AND id = :id");
        $statement->execute([":id" => $adminId]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
