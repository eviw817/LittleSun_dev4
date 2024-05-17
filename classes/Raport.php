<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "Db.php");

class Raport {
    public static function generateReport($user, $location, $taskType, $dateFrom, $dateTo) {
        $conn = Db::getConnection();

$query = "SELECT u.firstName, u.lastName, l.name AS locationName, t.name AS taskName, wl.total_hours, wl.overtime_hours 
        FROM work_logs wl
        JOIN users u ON wl.userId = u.id
        JOIN users_tasks ut ON u.id = ut.user_Id
        JOIN tasks t ON ut.task_Id = t.id
        JOIN locations l ON u.location = l.id
        WHERE 1=1";


        $params = [];

        if (!empty($user)) {
            $query .= " AND wl.userId = :user_id";
            $params['user_id'] = $user;
        }
        if (!empty($location)) {
            $query .= " AND u.location = :location_id";
            $params['location_id'] = $location;
        }
        if (!empty($taskType)) {
            $query .= " AND t.id = :task_id";
            $params['task_id'] = $taskType;
        }
        if (!empty($dateFrom)) {
            $query .= " AND wl.total_hours >= :date_from";
            $params['date_from'] = $dateFrom;
        }
        if (!empty($dateTo)) {
            $query .= " AND wl.overtime_hours <= :date_to";
            $params['date_to'] = $dateTo;
        }

        $stmt = $conn->prepare($query);
        if ($stmt->execute($params)) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "Error executing query: " . htmlspecialchars($errorInfo[2]);
            return [];
        }
    }
}
?>
