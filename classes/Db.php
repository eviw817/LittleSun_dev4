<?php
abstract class Db
{
    private static $db;

    public static function getConnection()
    {
        if (self::$db == null) {
            self::$db = new PDO("mysql:host=localhost;dbname=little sun", "root", "root");
            return self::$db;
        } else {
            return self::$db;
        }
    }
}