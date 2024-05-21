<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "Db.php");

class Schedules
{
    private $id;
    private $user_id;
    private $task_id;
    private $location_id;
    private $schedule_date;
    private $startTime;
    private $endTime;

    public function __construct($user_id, $task_id, $location_id, $schedule_date, $startTime, $endTime)
    {
        $this->user_id = $user_id;
        $this->task_id = $task_id;
        $this->location_id = $location_id;
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

    public static function getUsers()
    {
        $conn = Db::getConnection();
        $statement = $conn->query("SELECT * FROM users");
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSchedules()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT s.*, u.username, t.name, l.name
                                    FROM schedules s
                                    JOIN users u ON u.id = s.user_id
                                    JOIN tasks t ON t.id = s.task_id
                                    JOIN locations l ON l.id = s.location_id");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSheduleById($scheduleId)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT s.*, u.id, u.username, t.id, t.name, l.id, l.name
                                    FROM schedules s
                                    JOIN users u ON u.id = s.user_id
                                    JOIN tasks t ON t.id = s.task_id
                                    JOIN locations l ON l.id = s.location_id
                                    WHERE s.id = :id");
        $statement->execute([":id" => $scheduleId]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function newShift()
    {
        if ($this->hasTimeOff()) {
            return "User has approved time off during this period.";
        }

        // Databaseverbinding maken
        $conn = Db::getConnection();

        // Voorbereiden van de SQL-instructie
        $statement = $conn->prepare("INSERT INTO schedules (user_id, task_id, location_id, schedule_date, start_time, end_time) 
                                    VALUES (:user_id, :task_id, :location_id, :schedule_date, :startTime, :endTime)");

        // Bind parameters aan de SQL-instructie
        $statement->bindValue(":user_id", $this->user_id);
        $statement->bindValue(":task_id", $this->task_id);
        $statement->bindValue(":location_id", $this->location_id);
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

    public static function getShiftsById($locationId, $afterDate)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT s.*, t.name, u.username 
            FROM schedules s 
            LEFT JOIN users u ON s.user_id = u.id 
            LEFT JOIN tasks t ON s.task_id = t.id 
            WHERE u.location = :id and s.start_time > :afterDate
            ORDER BY s.start_time ASC");
        $statement->bindValue(":id", $locationId, PDO::PARAM_INT);
        $statement->bindValue(":afterDate", $afterDate->format('Y-m-d'));
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function getShiftsByUser($userId, $afterDate)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT s.*, t.name, u.username
        FROM schedules s 
        LEFT JOIN tasks t ON s.task_id = t.id
        LEFT JOIN users u ON s.user_id = u.id
        WHERE s.user_id = :userId AND s.schedule_date >= :afterDate
        ORDER BY s.schedule_date, s.start_time ASC");
        $statement->bindValue(":userId", $userId, PDO::PARAM_INT);
        $statement->bindValue(":afterDate", $afterDate->format('Y-m-d'));
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
