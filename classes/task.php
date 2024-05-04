<?php

    class Task{
        private string $id;
        private string $name;
        private string $description;
        private string $category;
        private string $progress;
        private string $startDate;
        private string $endDate;

        public function __construct($name, $description, $category, $progress, $startDate, $endDate){
            $this->name = $name;
            $this->description = $description;
            $this->category = $category;
            $this->progress = $progress;
            $this->startDate = $startDate;
            $this->endDate = $endDate;
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

        
    }