<?php
   include_once(__DIR__ . DIRECTORY_SEPARATOR . "/Db.php");
   

    class HubLocation {
        private string $name;
        private string $street;
        private string $streetnumber;
        private string $city;
        private string $country;
        private string $postalcode;


        /**
         * Get the value of name
         */ 
        public function getName()
        {
                return $this->name;
        }

        /**
         * Set the value of name
         *
         * @return  self
         */ 
        public function setName($name)
        {
            if(!empty($name)){
                $this->name = $name; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("name connot be empty");
            }
        }

           /**
         * Get the value of street
         */ 
        public function getStreet()
        {
                return $this->street;
        }

        /**
         * Set the value of street
         *
         * @return  self
         */ 
        public function setStreet($street)
        {
            if(!empty($street)){
                $this->street = $street; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("street connot be empty");
            }
        }

        /**
         * Get the value of streetnumber
         */ 
        public function getStreetnumber()
        {
                return $this->streetnumber;
        }

        /**
         * Set the value of streetnumber
         *
         * @return  self
         */ 
        public function setStreetnumber($streetnumber)
        {
            if(!empty($streetnumber)){
                $this->streetnumber = $streetnumber; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("streetnumber connot be empty");
            }
        }

        /**
         * Get the value of city
         */ 
        public function getCity()
        {
                return $this->city;
        }

        /**
         * Set the value of city
         *
         * @return  self
         */ 
        public function setCity($city)
        {
            if(!empty($city)){
                $this->city = $city; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("city connot be empty");
            }
        }

        /**
         * Get the value of country
         */ 
        public function getCountry()
        {
                return $this->country;
        }

        /**
         * Set the value of country
         *
         * @return  self
         */ 
        public function setCountry($country)
        {
            if(!empty($country)){
                $this->country = $country; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("country connot be empty");
            }
        }

        /**
         * Get the value of postalcode
         */ 
        public function getPostalcode()
        {
                return $this->postalcode;
        }

        /**
         * Set the value of postalcode
         *
         * @return  self
         */ 
        public function setPostalcode($postalcode)
        {
            if(!empty($postalcode)){
                $this->postalcode = $postalcode; //this: het huidige object dat je mee werkt
            }
            else{
                throw new Exception("postalcode connot be empty");
            }
        }

        public function newLocation() {
            $conn = Db::getConnection();
            
            // Prepare query (INSERT) + bind
            $statement = $conn->prepare("INSERT INTO locations (name, street, streetNumber, city, country, postalCode) VALUES (:name, :street, :streetNumber, :city, :country, :postalCode);");
            $statement->bindValue("name", $this->name);
            $statement->bindValue("street", $this->street);
            $statement->bindValue("streetnumber", $this->streetnumber);
            $statement->bindValue("city", $this->city);
            $statement->bindValue("country", $this->country);
            $statement->bindValue("postalcode", $this->postalcode);
            
            // Execute
            return $statement->execute();
        }
        
       
     
    }