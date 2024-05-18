<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "Db.php");

class Report
{
    public static function generateReport($type, $startDate = null, $endDate = null, $userId = null, $taskId = null)
    {
        $conn = Db::getConnection();
        
        switch ($type) {
            case 'hoursWorked':
                $query = "SELECT u.username, SUM(TIMESTAMPDIFF(HOUR, s.start_time, s.end_time)) AS total_hours 
                          FROM schedules s
                          JOIN users u ON u.id = s.user_id
                          WHERE s.schedule_date BETWEEN :start_date AND :end_date
                          GROUP BY u.username";
                break;
            case 'hoursOvertime':
                $query = "SELECT u.username, SUM(TIMESTAMPDIFF(HOUR, s.start_time, s.end_time)) - 40 AS overtime_hours 
                          FROM schedules s
                          JOIN users u ON u.id = s.user_id
                          WHERE s.schedule_date BETWEEN :start_date AND :end_date
                          GROUP BY u.username
                          HAVING overtime_hours > 0";
                break;
            case 'sickTime':
                $query = "SELECT u.username, SUM(TIMESTAMPDIFF(HOUR, a.startDateTime, a.endDateTime)) AS sick_hours 
                          FROM absence_requests a
                          JOIN users u ON u.id = a.user_id
                          WHERE a.reason = 'sick' AND a.startDateTime BETWEEN :start_date AND :end_date";
                if ($userId) {
                    $query .= " AND a.user_id = :user_id";
                }
                $query .= " GROUP BY u.username";
                break;
            case 'timeOff':
                $query = "SELECT u.username, SUM(TIMESTAMPDIFF(HOUR, a.startDateTime, a.endDateTime)) AS time_off_hours 
                          FROM absence_requests a
                          JOIN users u ON u.id = a.user_id
                          WHERE a.startDateTime BETWEEN :start_date AND :end_date
                          GROUP BY u.username";
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
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
