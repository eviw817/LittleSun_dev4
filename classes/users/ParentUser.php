<?php 
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../Db.php");

    class ParentUser{
        protected string $id;
        protected string $username;  
        protected ?string $email;
        protected string $password;
        protected string $role;
        protected ?string $location;
        protected string $firstName;
        protected string $lastName;
        protected string $image;

        // contruct => geeft properties mee om in te vullen bij "new Manager", "new User", ...
        public function __construct($username, $email, $password, $role, $location, $firstName, $lastName){
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->role = $role;
            $this->location = $location;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
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

        //Set the value of username
        public function setUsername($username)
        {
            if(!empty($username)){
                $this->username = $username; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("username cannot be empty");
            }
        }
        //Get the value of username
        public function getUsername()
        {
            return $this->username;
        }

        //Set the value of email
        public function setEmail($email)
        {
            $this->email = $email;

                return $this;
        }
        //Get the value of email
        public function getEmail()
        {
                return $this->email;
        }

        //Set the value of password
        public function setPassword($password)
        {
            if(!empty($password)){
                $this->password = $password; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("password cannot be empty");
            }
        }
        //Get the value of password
        public function getPassword()
        {
                return $this->password;
        }

        //Set the value of role
        public function setRole($role)
        {
            if(!empty($role)){
                $this->role = $role; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("role cannot be empty");
            }
        }
        //Get the value of role
        public function getRole()
        {
                return $this->role;
        }

        //Set the value of location
        public function setLocation($location)
        {
                $this->location = $location;

                return $this;
        }
        //Get the value of location
        public function getLocation()
        {
                return $this->location;
        }

        //Set the value of firstName
        public function setFirstName($firstName)
        {
            if(!empty($firstName)){
                $this->firstName = $firstName; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("firstname cannot be empty");
            }
        }
        //Get the value of firstName
        public function getFirstName()
        {
                return $this->firstName;
        }
        
        //Set the value of lastName
        public function setLastName($lastName)
        {
            if(!empty($lastName)){
                $this->lastName = $lastName; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("lastname cannot be empty");
            }
        }
        //Get the value of lastName
        public function getLastName()
        {
                return $this->lastName;
        }

        //Set the value of image
        public function setImage($image)
        {
                $this->image = $image;

                return $this;
        }
        //Get the value of image 
        public function getImage()
        {
                return $this->image;
        }
        
    }