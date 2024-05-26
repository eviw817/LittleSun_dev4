<?php
abstract class Db
{
    private static $db;

    public static function getConnection()
    {
        if (self::$db == null) {
            self::$db = new PDO("mysql:host=ID437011_LittleSun.db.webhosting.be;dbname=ID437011_LittleSun", "ID437011_LittleSun", "ls24eihd4");
            return self::$db;
        } else {
            return self::$db;
        }
    }
}
