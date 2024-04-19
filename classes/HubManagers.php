<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "./Db.php");
    
    class Hubmanagers{
        private string $username;  
        private string $email;
        private string $password;
        private string $role;
        // private string $location;
        private string $firstName;
        private string $lastName;
    
        /**
         * Get the value of username
         */ 
        public function getUsername()
        {
                return $this->username;
        }

        /**
         * Set the value of username
         *
         * @return  self
         */ 
        public function setUsername($username)
        {
            if(!empty($username)){
                $this->username = $username; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("username cannot be empty");
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
            if(!empty($email)){
                $this->email = $email; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("email cannot be empty");
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
            if(!empty($password)){
                $this->password = $password; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("password cannot be empty");
            }
        }

        /**
         * Get the value of role
         */ 
        public function getRole()
        {
                return $this->role;
        }

        /**
         * Set the value of role
         *
         * @return  self
         */ 
        public function setRole($role)
        {
            if(!empty($role)){
                $this->role = $role; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("role cannot be empty");
            }
        }

        // /**
        //  * Get the value of location
        //  */ 
        // public function getLocation()
        // {
        //         return $this->location;
        // }

        // /**
        //  * Set the value of location
        //  *
        //  * @return  self
        //  */ 
        // public function setLocation($location)
        // {
        //     if(!empty($location)){
        //         $this->location = $location; //this: het huidige object dat je mee werkt
        //     }
        //     else{
        //         throw new Exception("location cannot be empty");
        //     }
        // }
        /**
         * Get the value of firstName
         */ 
        public function getFirstName()
        {
                return $this->firstName;
        }

        /**
         * Set the value of firstName
         *
         * @return  self
         */ 
        public function setFirstName($firstName)
        {
            if(!empty($firstName)){
                $this->firstName = $firstName; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("firstName cannot be empty");
            }
        }

        /**
         * Get the value of lastName
         */ 
        public function getLastName()
        {
                return $this->lastName;
        }

        /**
         * Set the value of lastName
         *
         * @return  self
         */ 
        public function setLastName($lastName)
        {
            if(!empty($lastName)){
                $this->lastName = $lastName; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("lastName cannot be empty");
            }
        }

        public function newManager(){
            //PDO connection
            $conn = Db::getConnection();
            //prepare query (INSERT) + bind
            $statement = $conn->prepare("INSERT INTO users (username, email, password, role, firstName, lastName) VALUES (:username, :email, :password, :role, :firstName, :lastName);"); //locatie nog toevoegen
            $statement->bindValue(":username", $this->username);
            $statement->bindValue(":email", $this->email);
            $statement->bindValue(":password", $this->password);
            $statement->bindValue(":role", $this->role);
            // $statement->bindValue(":location", $this->location);
            $statement->bindValue(":firstName", $this->firstName);
            $statement->bindValue(":lastName", $this->lastName);
           // $statement->bindValue("location", implode(',', $this->location));
            //excute
            return $statement->execute();//terug geven het resultaat van die query
            //result return
        }

        // public function newLocation() {
        //     $conn = Db::getConnection();
            
        //     // Prepare query (INSERT) + bind
        //     $statement = $conn->prepare("INSERT INTO locations (name, street, streetNumber, city, country, postalCode) VALUES (:name, :street, :streetNumber, :city, :country, :postalCode);");
        //     $statement->bindValue(":name", $this->name);
        //     $statement->bindValue(":street", $this->street);
        //     $statement->bindValue(":streetNumber", $this->streetnumber);
        //     $statement->bindValue(":city", $this->city);
        //     $statement->bindValue(":country", $this->country);
        //     $statement->bindValue(":postalCode", $this->postalcode);
            
        //     // Execute
        //     return $statement->execute();
        // }
}
    
