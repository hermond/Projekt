<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-30
 * Time: 14:22
 * To change this template use File | Settings | File Templates.
 */

namespace model;


class MainStoreDBSettings {
    /**
     * @var String
     */
    private $mainStoreUrl;
    /**
     * @var String
     */
    private $dbHost;
    /**
     * @var String
     */
    private $dbUsername;
    /**
     * @var String
     */
    private $dbPassword;
    /**
     * @var String
     */
    private $dbName;

    /**
     * @param String $mainStoreUrl
     * @param String $dbHost
     * @param String $dbUsername
     * @param String $dbPassword
     * @param String $dbName
     * @throws Exception If validation fails
     */
    public function __construct($mainStoreUrl, $dbHost, $dbUsername, $dbPassword, $dbName){

        if (!is_string($mainStoreUrl) || !strlen($mainStoreUrl) > 0) {
            throw new \Exception("The Main Store url is missing or not a string");
        }

        if(preg_match("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/", $mainStoreUrl) == false)
        {
            throw new \Exception ("The Main Store url is not a valid url");
        }

        if (!is_string($dbHost) || !strlen($dbHost) > 0) {
            throw new \Exception("The database hostname is missing or not a string");
        }
        if (!is_string($dbUsername) || !strlen($dbUsername) > 0) {
            throw new \Exception("The datbase hostname is missing or not a string");
        }
        if (!is_string($dbPassword) || !strlen($dbPassword) > 0) {
            throw new \Exception("The datbase hostname is missing or not a string");
        }
        if (!is_string($dbName) || !strlen($dbName) > 0) {
            throw new \Exception("The datbase hostname is missing or not a string");
        }


        $this->mainStoreUrl = $mainStoreUrl;
        $this->dbHost = $dbHost;
        $this->dbUsername = $dbUsername;
        $this->dbPassword = $dbPassword;
        $this->dbName = $dbName;

    }

    public function getMainStoreUrl()
    {
        return $this->mainStoreUrl;
    }

    public function getDBHost()
    {
        return $this->dbHost;
    }

    public function getDBUsername()
    {
        return $this->dbUsername;
    }

    public function getDBPassword()
    {
        return $this->dbPassword;
    }

    public function getDBName()
    {
        return $this->dbName;
    }

}