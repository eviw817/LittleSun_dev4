<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "ParentUser.php");

    class User extends ParentUser
    {

        //addUser.php
        public function newUser()
        {
            //PDO connection
            $conn = Db::getConnection();
            //prepare query (INSERT) + bind
            $statement = $conn->prepare("INSERT INTO users (username, firstName, lastName, role, email, password, image) VALUES (:username, :firstName, :lastName, 'user', :email, :password, :image);"); //locatie nog toevoegen
            $statement->bindValue(":username", $this->username);
            $statement->bindValue(":firstName", $this->firstName);
            $statement->bindValue(":lastName", $this->lastName);
            $statement->bindValue(":email", $this->email);
            $statement->bindValue(":password", $this->password);
            $statement->bindValue(":image", (!empty($this->image)) ? $this->image : 'data:image/png;base64,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');

            return $statement->execute(); //terug geven het resultaat van die query
            //result return
        }

        //user.php
        public static function getName()
        {
            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT id, firstName, lastName, image FROM users WHERE role = 'user'");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        //userId.php
        public static function getUserById($userId)
        {
            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT u.*, l.name FROM users u LEFT JOIN locations l ON u.location = l.id WHERE u.id = :id AND role = 'user'");
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

        public static function getAllUsers(){
            $conn = Db::getConnection();
            $statement = $conn->query("SELECT * FROM users u WHERE role = 'user'");
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }
