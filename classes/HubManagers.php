<?php
    class HubManagers {
        private string $firstname;
        private string $lastname;
        private string $email;
        private string $password;
        private string $location;
        

        /**
         * Get the value of firstname
         */ 
        public function getFirstname()
        {
                return $this->firstname;
        }

        /**
         * Set the value of firstname
         *
         * @return  self
         */ 
        public function setFirstname($pFirstname)
        {
            if(!empty($pFirstname)){
                $this->firstname = $pFirstname; 
            }
            else{
                throw new Exception("Firstname connot be empty");
            }
        }

        /**
         * Get the value of lastname
         */ 
        public function getLastname()
        {
                return $this->lastname;
        }

        /**
         * Set the value of lastname
         *
         * @return  self
         */ 
        public function setLastname($pLastname)
        {
            if(!empty($pLastname)){
                $this->lastname = $pLastname; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("lastname connot be empty");
            }
        }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
            if(!empty($pEmail)){
                $this->email = $pEmail; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("email connot be empty");
            }
        }

        /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @return  self
         */ 
        public function setPassword($password)
        {
            if(!empty($pPassword)){
                $this->password = $pPassword; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("password connot be empty");
            }
        }

        /**
         * Get the value of location
         */ 
        public function getLocation()
        {
                return $this->location ;
        }

        /**
         * Set the value of location
         *
         * @return  self
         */ 
        public function setLocation()
        {
                $this->location = array("Location 1", "Location 2", "Location 3");

                return $this;
        }
    }
//nog doen
    // public function save(){
    //     //PDO connection
    //     $conn = new PDO('mysql:host=localhost;dbname=studentcards', 'root', 'root');
    //     //prepare query (INSERT) + bind
    //     $statement = $conn->prepare("INSERT into students (firstname, lastname) values (:firstname, :lastname)");
    //     $statement->bindValue("firstname", $this->firstname);
    //     $statement->bindValue("lastname", $this->lastname);
    //     //excute
    //     return $statement->execute();//terug geven het resultaat van die query
    //     //result return
    // }

    // public static function getAll(){
    //     $conn = new PDO('mysql:host=localhost;dbname=studentcards', 'root', 'root');
    //     $statement = $conn->prepare("SELECT * FROM students"); //prepare is niet altijd nodig omdat je hier niets moet bonden
    //     $statement->execute();
    //     $arrResult = $statement->fetchAll(PDO::FETCH_ASSOC);
    //     return $arrResult;
    // }