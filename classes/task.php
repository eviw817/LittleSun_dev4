<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "Db.php");

    class Task{
        private string $id;
        private string $name;
        private string $description;
        private string $category;
        private string $progress;
        private string $startDate;
        private string $endDate;

        public function __construct($name, $description, $category){ //, $progress, $startDate, $endDate
            $this->name = $name;
            $this->description = $description;
            $this->category = $category;
            // $this->progress = $progress;
            // $this->startDate = $startDate;
            // $this->endDate = $endDate;
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

        //Set the value of name 
        public function setName($name)
        {
                $this->name = $name;

                return $this;
        }
        //Get the value of name
        public function getName()
        {
                return $this->name;
        }

        //Set the value of description 
        public function setDescription($description)
        {
                $this->description = $description;

                return $this;
        }
        //Get the value of description
        public function getDescription()
        {
                return $this->description;
        }
        
        //Set the value of category
        public function setCategory($category)
        {
                $this->category = $category;

                return $this;
        }
        //Get the value of category 
        public function getCategory()
        {
                return $this->category;
        }

        //Set the value of progress
        public function setProgress($progress)
        {
                $this->progress = $progress;

                return $this;
        }
        //Get the value of progress
        public function getProgress()
        {
                return $this->progress;
        }

        //Set the value of startDate
        public function setStartDate($startDate)
        {
                $this->startDate = $startDate;

                return $this;
        }
        //Get the value of startDate
        public function getStartDate()
        {
                return $this->startDate;
        }

        //Set the value of endDate
        public function setEndDate($endDate)
        {
                $this->endDate = $endDate;

                return $this;
        }        //Get the value of endDate
        public function getEndDate()
        {
                return $this->endDate;
        }

        public function saveTask()
        {
            $conn = Db::getConnection();

            // Prepare query (INSERT) + bind
            $statement = $conn->prepare("INSERT INTO tasks (name, description, category) VALUES (:name, :description, :category);");
            $statement->bindValue(":name", $this->name);
            $statement->bindValue(":description", $this->description);
            $statement->bindValue(":category", $this->category);
           
            // Execute
            $processed = $statement->execute();
            if ($processed) {
                return $processed;
            } else {
                throw new Exception("Task couldn't be added into the database");
            }
        }

        public function updateTask(){
            if(!empty($this->id)){
            $conn = Db::getConnection();
            $statement = $conn->prepare("UPDATE tasks SET name = :name, description = :description, category = :category WHERE id = :id");
            $statement->execute([
                ":name" => $this->name,
                ":description" => $this->description,
                ":category" => $this->category,
                ":id" => $this->id
            ]);
            } else{
                throw new Exception("id is not set.");
            }
        }

        //taskEdit
        // Functie om taakgegevens op te halen op basis van ID
        public static function getTaskById($taskId)
        {
            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT t.*, u.username FROM tasks t LEFT JOIN users_tasks ut ON ut.task_id = t.id LEFT JOIN users u ON ut.user_id = u.id WHERE t.id = :id");
            $statement->execute([":id" => $taskId]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        //database geeft mij de zaken die er al in staan voor task
        public static function getTasks(){
            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT id, name FROM tasks");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function deleteTask($taskId)
        {
            $conn = Db::getConnection();
            $statement = $conn->prepare("DELETE FROM tasks WHERE id = :id");
            $statement->execute([":id" => $taskId]);
        }

        public static function fetchAllCategories(){
                $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT DISTINCT category FROM tasks");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function fetchProgress(){
            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT DISTINCT progress FROM tasks");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function AssignUserToTask($userId){
            if(!empty($this->id)){
                $conn = Db::getConnection();
                $statement = $conn->prepare("INSERT INTO users_tasks (user_Id, task_Id) VALUES (:user_Id, :task_Id)");
                $statement->execute([
                    ":user_Id" => $userId,
                    ":task_Id" => $this->id,
                ]);
                } else{
                    throw new Exception("User could not be assigned.");
                }
        }

            
        public static function removeUserFromTask($taskId, $userId) {
            $conn = Db::getConnection();
            $statement = $conn->prepare("DELETE FROM users_tasks WHERE task_id = :task_id AND user_id = :user_id");
            $statement->execute([
                ":task_id" => $taskId,
                ":user_id" => $userId
            ]);
        }

    
    }