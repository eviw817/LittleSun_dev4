<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../Db.php");

class Absence
{
        protected string $id;
        protected ?string $startDateTime;
        protected ?string $endDateTime;
        protected ?string $typeOfAbsence;
        protected ?string $reason;

        public function __construct($startDateTime, $endDateTime, $typeOfAbsence, $reason)
        {
                $this->startDateTime = $startDateTime;
                $this->endDateTime = $endDateTime;
                $this->typeOfAbsence = $typeOfAbsence;
                $this->reason = $reason;
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

        //Set the value of startDateTime
        public function setStartDateTime($startDateTime)
        {
                $this->startDateTime = $startDateTime;

                return $this;
        }
        //Get the value of startDateTime
        public function getStartDateTime()
        {
                return $this->startDateTime;
        }

        //Set the value of endDateTime
        public function setEndDateTime($endDateTime)
        {
                $this->endDateTime = $endDateTime;

                return $this;
        }
        //Get the value of endDateTime 
        public function getEndDateTime()
        {
                return $this->endDateTime;
        }

        //Set the value of typeOfAbsence
        public function setTypeOfAbsence($typeOfAbsence)
        {
                $this->typeOfAbsence = $typeOfAbsence;

                return $this;
        }
        //Get the value of typeOfAbsence
        public function getTypeOfAbsence()
        {
                return $this->typeOfAbsence;
        }

        //Set the value of reason
        public function setReason($reason)
        {
                $this->reason = $reason;

                return $this;
        }
        //Get the value of reason
        public function getReason()
        {
                return $this->reason;
        }
}
