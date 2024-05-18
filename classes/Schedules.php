<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "Db.php");

class Schedules
{
    private $id;
    private $user_id;
    private $user_name;
    private $task_id;
    private $task_name;
    private $location_id;
    private $location_name;
    private $schedule_date;
    private $startTime;
    private $endTime;

    public function __construct($user_id, $user_name, $task_id, $task_name, $location_id, $location_name, $schedule_date, $startTime, $endTime)
    {
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->task_id = $task_id;
        $this->task_name = $task_name;
        $this->location_id = $location_id;
        $this->location_name = $location_name;
        $this->schedule_date = $schedule_date;
        $this->startTime = new DateTime($startTime . ":00");
        $this->endTime = new DateTime($endTime . ":00");
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
     * Get the value of user_id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of user_name
     */
    public function getUser_name()
    {
        return $this->user_name;
    }

    /**
     * Set the value of user_name
     *
     * @return  self
     */
    public function setUser_name($user_name)
    {
        $this->user_name = $user_name;

        return $this;
    }

    /**
     * Get the value of task_id
     */
    public function getTask_id()
    {
        return $this->task_id;
    }

    /**
     * Set the value of task_id
     *
     * @return  self
     */
    public function setTask_id($task_id)
    {
        $this->task_id = $task_id;

        return $this;
    }

    /**
     * Get the value of task_name
     */
    public function getTask_name()
    {
        return $this->task_name;
    }

    /**
     * Set the value of task_name
     *
     * @return  self
     */
    public function setTask_name($task_name)
    {
        $this->task_name = $task_name;

        return $this;
    }

    /**
     * Get the value of location_id
     */
    public function getLocation_id()
    {
        return $this->location_id;
    }

    /**
     * Set the value of location_id
     *
     * @return  self
     */
    public function setLocation_id($location_id)
    {
        $this->location_id = $location_id;

        return $this;
    }

    /**
     * Get the value of location_name
     */
    public function getLocation_name()
    {
        return $this->location_name;
    }

    /**
     * Set the value of location_name
     *
     * @return  self
     */
    public function setLocation_name($location_name)
    {
        $this->location_name = $location_name;

        return $this;
    }

    /**
     * Get the value of schedule_date
     */
    public function getSchedule_date()
    {
        return $this->schedule_date;
    }

    /**
     * Set the value of schedule_date
     *
     * @return  self
     */
    public function setSchedule_date($schedule_date)
    {
        $this->schedule_date = $schedule_date;

        return $this;
    }

    /**
     * Get the value of startTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set the value of startTime
     *
     * @return  self
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get the value of endTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set the value of endTime
     *
     * @return  self
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    public static function getTasks()
    {
        $conn = Db::getConnection();
        $statement = $conn->query("SELECT * FROM tasks");
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getHubs()
    {
        $conn = Db::getConnection();
        $statement = $conn->query("SELECT * FROM locations");
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSchedules()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT s.*, u.username AS user_name, t.name AS task_name, l.name AS location_name, s.start_time AS startTime, s.end_time AS endTime
                                    FROM schedules s
                                    JOIN users u ON u.id = s.user_id
                                    JOIN tasks t ON t.id = s.task_id
                                    JOIN locations l ON l.id = s.location_id");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }



    public function newShift()
    {
        if ($this->hasTimeOff()) {
            return "User has approved time off during this period.";
        }

        // Databaseverbinding maken
        $conn = Db::getConnection();

        // Voorbereiden van de SQL-instructie
        $statement = $conn->prepare("INSERT INTO schedules (user_id, user_name, task_id, task_name, location_id, location_name, schedule_date, start_time, end_time) 
                                    VALUES (:user_id, :user_name, :task_id, :task_name, :location_id, :location_name, :schedule_date, :startTime, :endTime)");

        // Bind parameters aan de SQL-instructie
        $statement->bindValue(":user_id", $this->user_id);
        $statement->bindValue(":user_name", $this->user_name);
        $statement->bindValue(":task_id", $this->task_id);
        $statement->bindValue(":task_name", $this->task_name);
        $statement->bindValue(":location_id", $this->location_id);
        $statement->bindValue(":location_name", $this->location_name);
        $statement->bindValue(":schedule_date", $this->schedule_date);
        $statement->bindValue(":startTime", $this->startTime->format('H:i:s'));
        $statement->bindValue(":endTime", $this->endTime->format('H:i:s'));
    
        // Uitvoeren van de SQL-instructie
        return $statement->execute() ? true : "Failed to assign shift.";
    }
    


    private function hasTimeOff()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT * FROM absence_requests WHERE user_id = :user_id AND (:schedule_date BETWEEN startDateTime AND endDateTime)');
        $statement->bindValue(':user_id', $this->user_id);
        $statement->bindValue(':schedule_date', $this->schedule_date . ' ' . $this->startTime->format('H:i:s'));
        $statement->execute();
        return $statement->fetch() ? true : false;
    }

    public static function getShiftsById($locationId, $afterDate) {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT s.*, t.name, t.description, u.firstName, u.lastName 
            FROM shifts s 
            LEFT JOIN users u ON s.user_id = u.id 
            LEFT JOIN tasks t ON s.task_id = t.id 
            WHERE u.location = :locationId and s.startTime > :afterDate
            ORDER BY s.startTime ASC");
        $statement -> bindValue(":locationId", $locationId, PDO::PARAM_INT);
        $statement -> bindValue(":afterDate", $afterDate->format('Y-m-d'));
        $statement -> execute();
        return $statement->fetchAll();
    }
}