<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "Db.php");

class Report
{
    public static function generateReport($type, $startDate = null, $endDate = null, $userId = null, $taskId = null)
    {
        $conn = Db::getConnection();
        
        switch ($type) {
            case 'hoursWorked':
                $query = "SELECT u.username, t.name AS task_name, s.start_time, s.end_time, TIMESTAMPDIFF(HOUR, s.start_time, s.end_time) AS total_hours 
                          FROM schedules s
                          JOIN users u ON u.id = s.user_id
                          JOIN tasks t ON t.id = s.task_id
                          WHERE s.schedule_date BETWEEN :start_date AND :end_date";
                if ($userId) {
                    $query .= " AND s.user_id = :user_id";
                }
                if ($taskId) {
                    $query .= " AND s.task_id = :task_id";
                }
                break;
        case 'hoursOvertime':
            $query = "SELECT u.username, t.name AS task_name, wl._in_time AS start_time, wl.clock_out_time AS end_time, TIMESTAMPDIFF(HOUR, wl.clock_in_time, wl.clock_out_time) - 40 AS overtime_hours 
                    FROM work_logs wl
                    JOIN users u ON u.id = wl.userId
                    JOIN tasks t ON t.id = s.task_id
                    WHERE wl.clock_in_time BETWEEN :start_date AND :end_date
                    HAVING overtime_hours > 0";
                if ($userId) {
                    $query .= " AND s.user_id = :user_id";
                }
                if ($taskId) {
                    $query .= " AND s.task_id = :task_id";
                }
            break;
            case 'sickTime':
                $query = "SELECT u.username, t.name AS task_name, s.start_time, s.end_time, TIMESTAMPDIFF(HOUR, s.start_time, s.end_time) AS sick_hours 
                          FROM absence_requests a
                          JOIN schedules s /*ON a.user_id = s.user_id*/
                          JOIN users u ON u.id = s.user_id
                          JOIN tasks t ON t.id = s.task_id
                          WHERE a.reason = 'Sick leave' AND a.startDateTime BETWEEN :start_date AND :end_date";
                if ($userId) {
                    $query .= " AND a.user_id = :user_id";
                }
                if ($taskId) {
                    $query .= " AND s.task_id = :task_id";
                }
                break;
                case 'timeOff':
                    $reasons = ['Sick leave', 'Vacation', 'Birthday', 'Maternity', 'Funeral', 'Wedding', 'Compensary time', 'Authority appointment', 'Other'];
                    $reasonList = implode("', '", $reasons);
                    $query = "SELECT u.username, t.name AS task_name, a.startDateTime, a.endDateTime, TIMESTAMPDIFF(HOUR, a.startDateTime, a.endDateTime) AS time_off_hours 
                            FROM absence_requests a
                            JOIN schedules s
                            JOIN users u ON u.id = a.user_id
                            JOIN tasks t ON t.id = a.task_id
                            WHERE a.reason IN ('$reasonList') AND a.startDateTime BETWEEN :start_date AND :end_date";
                    if ($userId) {
                        $query .= " AND a.user_id = :user_id";
                    }
                    if ($taskId) {
                        $query .= " AND s.task_id = :task_id";
                    }
                    break;
            default:
                throw new Exception("Invalid report type");
        }

        $statement = $conn->prepare($query);
        $statement->bindValue(':start_date', $startDate);
        $statement->bindValue(':end_date', $endDate);
        if ($userId) {
            $statement->bindValue(':user_id', $userId);
        }
        if ($taskId) {
            $statement->bindValue(':task_id', $taskId);
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
