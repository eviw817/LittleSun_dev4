<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "Db.php");

class Shift
{
    private $id;
    private $task_id;
    private $user_id;
    private $startTime;
    private $endTime;

    public function __construct($task_id, $user_id, $shiftDate, $startTime, $endTime)
    {
        $this->task_id = $task_id;
        $this->user_id = $user_id;
        $this->startTime = new DateTime($shiftDate . " " . $startTime . ":00");
        $this->endTime = new DateTime($shiftDate . " " . $endTime . ":00");
        return $this;
    }

    //Set the value of id
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    //Get the value of id
    public function getId()
    {
        return $this->id;
    }

    //Set the value of task_id
    public function setTask_id($task_id)
    {
        $this->task_id = $task_id;

        return $this;
    }
    //Get the value of task_id
    public function getTask_id()
    {
        return $this->task_id;
    }

    //Set the value of user_id
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }
    //Get the value of user_id
    public function getUser_id()
    {
        return $this->user_id;
    }

    //Set the value of cistartTimety
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }
    //Get the value of startTime
    public function getStartTime()
    {
        return $this->startTime;
    }

    //Set the value of endTime
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }
    //Get the value of endTime
    public function getEndTime()
    {
        return $this->endTime;
    }

    public function newShift()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO shifts (task_id, user_id, startTime, endTime) VALUES (:task_id, :user_id, :startTime, :endTime);");
        $statement->bindValue(":task_id", $this->task_id);
        $statement->bindValue(":user_id", $this->user_id);
        $statement->bindValue(":startTime", $this->startTime->format(DateTime::ATOM));
        $statement->bindValue(":endTime", $this->endTime->format(DateTime::ATOM));
        return $statement->execute();
    }

    public static function getShiftsById($locationId) {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT s.*, t.name, t.description, u.firstName, u.lastName FROM shifts s LEFT JOIN users u ON s.user_id = u.id LEFT JOIN tasks t ON s.task_id = t.id WHERE u.location = :locationId");
        $statement -> bindValue(":locationId", $locationId, PDO::PARAM_INT);
        $statement -> execute();
        return $statement->fetchAll();
    }

}
