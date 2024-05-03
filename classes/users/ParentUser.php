<?php 
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../Db.php");

    class ParentUser{
        protected string $id;
        protected string $username;  
        protected string $email;
        protected string $password;
        protected string $role;
        protected string $location;
        protected string $firstName;
        protected string $lastName;
        protected string $image;

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
            $this->username = $username;

            return $this;
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
                $this->password = $password;

                return $this;
        }
        //Get the value of password
        public function getPassword()
        {
                return $this->password;
        }

        //Set the value of role
        public function setRole($role)
        {
                $this->role = $role;

                return $this;
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
                $this->firstName = $firstName;

                return $this;
        }
        //Get the value of firstName
        public function getFirstName()
        {
                return $this->firstName;
        }
        
        //Set the value of lastName
        public function setLastName($lastName)
        {
                $this->lastName = $lastName;

                return $this;
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