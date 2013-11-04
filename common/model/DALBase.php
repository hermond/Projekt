<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-24
 * Time: 01:29
 * To change this template use File | Settings | File Templates.
 */

namespace model;


class DALBase {
    /**
     * @var string
     */
    private static $hostname = "mysql08.citynetwork.se";
    /**
     * @var string
     */
    private static $username = "112745-eb11930";
    /**
     * @var string
     */
    private static $password = "MakeMake22";
    /**
     * @var string
     */
    private static $dbName = "112745-projektet";
    /**
     * @var string
     */
    private static $charset = "UTF8";

    /**
     * @return PDO
     */
    public static function getDBConnection() {
        try {
            $pdo = new \PDO("mysql:host=" . self::$hostname . ";dbname=" . self::$dbName . ";charset=" . self::$charset
                , self::$username, self::$password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch (\PDOException $e) {

        }

        return $pdo;
    }

}