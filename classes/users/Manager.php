<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "ParentUser.php");

class Manager extends ParentUser
{
    public function newManager()
    {
        //PDO connection
        $conn = Db::getConnection();
        //prepare query (INSERT) + bind
        $statement = $conn->prepare("INSERT INTO users (username, email, password, role, location, firstName, lastName, image) VALUES (:username, :email, :password, :role, :location, :firstName, :lastName, :image);");
        $statement->bindValue(":username", $this->username);
        $statement->bindValue(":email", $this->email);
        $statement->bindValue(":password", $this->password);
        $statement->bindValue(":role", $this->role);
        $statement->bindValue(":location", $this->location);
        $statement->bindValue(":firstName", $this->firstName);
        $statement->bindValue(":lastName", $this->lastName);
        $statement->bindValue(":image", $this->image);

        return $statement->execute(); //terug geven het resultaat van die query
        //result return
    }

    /* Zoekt voor alle managers in een locatie gebaseerd op de Location ID*/
    public static function getByLocation($locationId)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT firstName, lastName FROM users WHERE location = :id AND role = 'manager'");
        $statement->execute([":id" => $locationId]);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (!$results) {
            return null;
        } else {
            return $results; // Retourneer de array met voornamen en achternamen
        }
    }

    // Functie om managergegevens op te halen op basis van ID
    public static function getManagerById($managerId)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT u.*, l.id, l.name FROM users u LEFT JOIN locations l ON u.location = l.id WHERE u.id = :id AND role = 'manager'");
        $statement->bindValue(":id", $managerId, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateInfo()
    {
        if (!empty($this->id)) {
            // Hash het wachtwoord als het niet leeg is
            if (!empty($this->password)) {
                $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
            } else {
                // Als het wachtwoord leeg is, behoud de huidige wachtwoordwaarde
                $hashed_password = $this->password;
            }

            $conn = Db::getConnection();
            $statement = $conn->prepare("UPDATE users SET username = :username, email = :email, password = :password, role = :role, location = :location, firstName = :firstName, lastName = :lastName, image = :image WHERE id = :id");
            $statement->execute([
                ":username" => $this->username,
                ":email" => $this->email,
                ":password" => $hashed_password, // Gebruik het gehashte wachtwoord
                ":role" => $this->role,
                ":location" => $this->location,
                ":firstName" => $this->firstName,
                ":lastName" => $this->lastName,
                ":image" => $this->image,
                ":id" => $this->id
            ]);
        } else {
            throw new Exception("id is not set.");
        }
    }

    // Functie om de lijst van hub managers op te halen
    public static function getHubManagerName()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT id, username, image FROM users WHERE role = 'manager'");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
