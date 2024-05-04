<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "./Db.php");


    class Location
    {
        private string $id;
        private string $name;
        private string $street;
        private string $streetnumber;
        private string $city;
        private string $country;
        private string $postalcode;

        public function __construct($name, $street, $streetnumber, $city, $country, $postalcode){
            $this->name = $name;
            $this->street = $street;
            $this->streetnumber = $streetnumber;
            $this->city = $city;
            $this->country = $country;
            $this->postalcode = $postalcode;

            return $this;
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
            if (!empty($name)) {
                $this->name = $name; //this: het huidige object dat je mee werkt
            } else {
                throw new Exception("name cannot be empty");
            }
        }
        //Get the value of name
        public function getName()
        {
            return $this->name;
        }

        //Set the value of street
        public function setStreet($street)
        {
            if (!empty($street)) {
                $this->street = $street; //this: het huidige object dat je mee werkt
            } else {
                throw new Exception("street cannot be empty");
            }
        }
        //Get the value of street
        public function getStreet()
        {
            return $this->street;
        }

        //Set the value of streetnumber
        public function setStreetnumber($streetnumber)
        {
            if (!empty($streetnumber)) {
                $this->streetnumber = $streetnumber; //this: het huidige object dat je mee werkt
            } else {
                throw new Exception("streetnumber cannot be empty");
            }
        }
        //Get the value of streetnumber
        public function getStreetnumber()
        {
            return $this->streetnumber;
        }

        //Set the value of city
        public function setCity($city)
        {
            if (!empty($city)) {
                $this->city = $city; //this: het huidige object dat je mee werkt
            } else {
                throw new Exception("city cannot be empty");
            }
        }
        //Get the value of city
        public function getCity()
        {
            return $this->city;
        }

        //Set the value of country
        public function setCountry($country)
        {
            if (!empty($country)) {
                $this->country = $country; //this: het huidige object dat je mee werkt
            } else {
                throw new Exception("country cannot be empty");
            }
        }
        //Get the value of country
        public function getCountry()
        {
            return $this->country;
        }
        
        //Set the value of postalcode
        public function setPostalcode($postalcode)
        {
            if (!empty($postalcode)) {
                $this->postalcode = $postalcode; //this: het huidige object dat je mee werkt
            } else {
                throw new Exception("postalcode cannot be empty");
            }
        }
        //Get the value of postalcode
        public function getPostalcode()
        {
            return $this->postalcode;
        }

        public function saveLocation()
        {
            $conn = Db::getConnection();

            // Prepare query (INSERT) + bind
            $statement = $conn->prepare("INSERT INTO locations (name, street, streetNumber, city, country, postalCode) VALUES (:name, :street, :streetNumber, :city, :country, :postalCode);");
            $statement->bindValue(":name", $this->name);
            $statement->bindValue(":street", $this->street);
            $statement->bindValue(":streetNumber", $this->streetnumber);
            $statement->bindValue(":city", $this->city);
            $statement->bindValue(":country", $this->country);
            $statement->bindValue(":postalCode", $this->postalcode);

            // Execute
            $processed = $statement->execute();
            if ($processed) {
                return $processed;
            } else {
                throw new Exception("Hub couldn't be added into the database");
            }
        }

        public function updateLocation(){
            if(!empty($this->id)){
            $conn = Db::getConnection();
            $statement = $conn->prepare("UPDATE locations SET name = :name, street = :street, streetNumber = :streetNumber, city = :city, country = :country, postalCode = :postalCode WHERE id = :id");
            $statement->execute([
                ":name" => $this->name,
                ":street" => $this->street,
                ":streetNumber" => $this->streetnumber,
                ":city" => $this->city,
                ":country" => $this->country,
                ":postalCode" => $this->postalcode,
                ":id" => $this->id
            ]);
            } else{
                throw new Exception("id is not set.");
            }
        }

        //hub.php
        public function getHubname()
        {
            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT id, name FROM locations");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        //hubId.php
        public function getUsersByLocation($locationId)
        {
            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT firstName, lastName, image FROM users WHERE location = :id AND role = 'user' ");
            $statement->execute([":id" => $locationId]);
            $results = $statement->fetchAll();
            if (!$results) {
                return null;
            } else {
                return $results;
            }
        }

        //hubId.php
        public function getHubLocationById($hubId)
        {
            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT * FROM locations WHERE id = :id");
            $statement->execute([":id" => $hubId]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                return null;
            } else {
                return $result;
            }
        }

        //editLocation
        // Functie om locatiegegevens op te halen op basis van ID
        public static function getLocationById($locationId)
        {
            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT l.* FROM locations l LEFT JOIN users u ON l.id = u.location WHERE l.id = :id");
            $statement->execute([":id" => $locationId]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
            var_dump($conn);
        }

        
    }
