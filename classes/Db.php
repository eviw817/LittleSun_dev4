<?php
    abstract class Db{
        private static $db;

        public static function getInstance(){
            if(self::$db == null){
                self::$db = new PDO("mysql:host=localhost;dbname=rentalApp", "root", "");
                return self::$db;
            }else{
                return self::$db;
            }
        }
    }