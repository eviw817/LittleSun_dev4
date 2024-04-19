<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "./Db.php");
    

    //abstract class HubManagers implements iNewmanager
         // protected string $firstname;
        // protected string $lastname;
        // protected string $email;
        // protected string $password;
        // protected string $location;
       // protected string $profile_pic;
    class Hubmanagers{
        private string $firstname;
        private string $lastname;
        private string $email;
        private string $password;
        //private array $location;
       
        

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
                throw new Exception("Firstname cannot be empty");
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
                throw new Exception("lastname cannot be empty");
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
        public function setEmail($pEmail)
        {
            if(!empty($pEmail)){
                $this->email = $pEmail; //this: het huidige object dat je mee werkt
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
        public function setPassword($pPassword)
        {
            if(!empty($pPassword)){
                $this->password = $pPassword; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("password cannot be empty");
            }
        }
   

        // /**
        //  * Get the value of location
        //  */ 
        // public function getLocation()
        // {
        //         return $this->location ;
        // }

        // /**
        //  * Set the value of location
        //  *
        //  * @return  self
        //  */ 
        // public function setLocation($pLocation)
        // {
        //     if (is_array($pLocation)) {
        //         $this->location = $pLocation;
        //     } else {
        //         throw new Exception("Location must be an array.");
        //     }
        //     return $this;
        // }

        /**
         * Get the value of profile_pic
         */ 
        // public function getProfile_pic()
        // {
        //         return $this->profile_pic;
        // }

        // /**
        //  * Set the value of profile_pic
        //  *
        //  * @return  self
        //  */ 
        // public function setProfile_pic($pProfile_pic)
        // {
        //     if(!empty($pProfile_pic)){
        //         $this->profile_pic = $pProfile_pic; //this: het huidige object dat je mee werkt
        //     }
        //     else{
        //         throw new Exception("profile_pic connot be empty");
        //     }
        // }
   

        public function newManager(){
            //PDO connection
            $conn = Db::getConnection();
            //prepare query (INSERT) + bind
            $statement = $conn->prepare("INSERT INTO users (username, email, password, role, location, firstName, lastName) VALUES (:username, :email, :password, :role, :location, :firstName, :lastName);");
            $statement->bindValue("u:sername", $this->username);
            $statement->bindValue(":email", $this->email);
            $statement->bindValue(":password", $this->password);
            $statement->bindValue(":role", $this->role);
            $statement->bindValue(":location", $this->location);
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
    
