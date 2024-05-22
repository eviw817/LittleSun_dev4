<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "ParentUser.php");

class User extends ParentUser
{

    //addUser.php
    public function newUser()
    {
        // Hash het wachtwoord
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT, ['cost' => 12]);

        //PDO connection
        $conn = Db::getConnection();
        //prepare query (INSERT) + bind
        $statement = $conn->prepare("INSERT INTO users (username, firstName, lastName, role, email, password, image, location) VALUES (:username, :firstName, :lastName, 'user', :email, :password, :image, :location);");
        $statement->bindValue(":username", $this->username);
        $statement->bindValue(":firstName", $this->firstName);
        $statement->bindValue(":password", $hashed_password);
        $statement->bindValue(":lastName", $this->lastName);
        $statement->bindValue(":email", $this->email);
        $statement->bindValue(":location", $this->location, PDO::PARAM_INT);
        $statement->bindValue(":password", $this->password);
        $statement->bindValue(":image", $this->image);
        

        return $statement->execute(); //terug geven het resultaat van die query
    }

    //user.php
    public static function getName()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT id, firstName, lastName, username,image FROM users WHERE role = 'user'");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    //userId.php
    public static function getUserById($userId)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT u.*, l.id, l.name FROM users u LEFT JOIN locations l ON u.location = l.id WHERE u.id = :id AND role = 'user'");
        $statement->execute([":id" => $userId]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /* Zoekt voor alle users met een task gebaseerd op de Task ID*/
    public static function getByTask($taskId)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT u.*, t.name FROM users u LEFT JOIN users_tasks ut ON ut.task_id = u.id LEFT JOIN tasks t ON ut.task_id = t.id WHERE t.id =  :id");
        $statement->execute([":id" => $taskId]);
        $results = $statement->fetchAll();
        if (!$results) {
            return null;
        } else {
            $users = [];
            foreach ($results as $result) {
                array_push($users, new User($result["username"], $result["email"], $result["password"], $result["role"], $result["location"], $result["firstName"], $result["lastName"]));
            }
            return $users;
        }
    }

    public static function getAllUsers()
    {
        $conn = Db::getConnection();
        $statement = $conn->query("SELECT * FROM users u WHERE role = 'user'");
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTaskFromUser($taskId)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT u.*, t.name 
                                         FROM users u 
                                         LEFT JOIN users_tasks ut ON ut.user_id = u.id 
                                         LEFT JOIN tasks t ON ut.task_id = t.id 
                                         WHERE u.id = :id");
        $statement->bindValue(':id', $taskId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getUsersByAvailability()
    {
        $conn = Db::getConnection();
        $statement = $conn->query("SELECT * FROM users u WHERE role = 'user'");
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getUsersByLocationAndRequests($locationId)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT u.* 
                FROM users u 
                LEFT JOIN absence_requests a ON a.user_id = u.id
                WHERE u.location = :location_id AND u.role = 'user' AND u.id NOT IN (SELECT user_id FROM absence_requests WHERE approvalStatus = 'Approved' OR approvalStatus = 'Pending')");
        $statement->bindParam(":location_id", $locationId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAuthorizationDetailsByUsername($pUsername)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = :tUsername");
        $statement->execute([":tUsername" => $pUsername]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function getUsersByLocation($locationId)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT u.* 
                                    FROM users u 
                                    JOIN users manager ON manager.id = :manager_id
                                    WHERE u.location = manager.location AND u.id != manager.id");
        $statement->bindParam(":manager_id", $_SESSION['id'], PDO::PARAM_INT);
        $statement->execute();
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public function updateInfo()
    {
        if (!empty($this->id)) {
            // Hash the password if it is not empty
            if (!empty($this->password)) {
                $hashed_password = password_hash($this->password, PASSWORD_DEFAULT, ['cost' => 12]);
            } else {
                // If the password is empty, keep the current password value
                $hashed_password = $this->password;
            }
            $conn = Db::getConnection();
            $statement = $conn->prepare("UPDATE users SET username = :username, email = :email, location = :location, password = :password, firstName = :firstName, lastName = :lastName, image = :image WHERE id = :id");
            $statement->execute([
                ":username" => $this->username,
                ":email" => $this->email,
                ":location" => $this->location,
                ":password" => $hashed_password, // Use the hashed password
                ":firstName" => $this->firstName,
                ":lastName" => $this->lastName,
                ":image" => $this->image,
                ":id" => $this->id
            ]);
        } else {
            throw new Exception("id is not set.");
        }
    }
}
