<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-26
 * Time: 16:29
 * To change this template use File | Settings | File Templates.
 */

namespace view;
use model\MainStoreDBSettings;
use model\SettingsHandler;

require_once('admin/model/MainStoreDBSettings.php');

class AdminDatabase {

    private $adminHTMLPageView;

    private static $title = "Main Store Settings";
    private $message = "";

    private static $saveSettings = "savesettings";
    private static $mainStoreUrl = "mainstoreurl";
    private static $DBhostname = "dbhostname";
    private static $DBusername = "dbusername";
    private static $DBpassword = "dbpassword";
    private static $DBname = "dbname";
    private static $submit = "submit";

    private $settingsHandler;


    public function __construct()
    {
        $this->settingsHandler = new SettingsHandler();
        $this->adminHTMLPageView = new AdminHTMLPage();
    }
    /**
     * @param admin\model\MainStoreDBSettings $product
     * @return string
     */

    public function getDBSettingsForm(MainStoreDBSettings $dbSettings)
    {
        $html = "
                <div id='mainstoresettings'>
                <p>".$this->message."</p>
                <form id='mainstoresettingsform' action='?admin&databasesettings&" . self::$saveSettings . "' method='post' >
                <table>
                <tr>
                <td><label>Main Store Url</label>
                <td><input type='text' name=".self::$mainStoreUrl." value='" . $dbSettings->getMainStoreUrl() ."'>
                </tr>
                <tr>
                <td><label>Hostname</label>
                <td><input type='text' name=".self::$DBhostname." value='" . $dbSettings->getDBHost() ."'>
                </tr>
                <tr>
                <td><label>Username</label>
                <td><input type='text' name=".self::$DBusername." value='". $dbSettings->getDBUsername()."'>
                </tr>
                <tr>
                <td><label>Password</label>
                <td><input type='password' name=".self::$DBpassword." value=''>
                </tr>
                <tr>
                <td><label>Database name</label>
                <td><input type='text' name=".self::$DBname." value ='". $dbSettings->getDBName()."'>
                </tr>
                <tr>
                <td>
                <td><input type='submit' name=".self::$submit." value='Save settings'>
                </tr>
                </table>
                </form>
                </div>";
        return $this->adminHTMLPageView->getAdminHTMLPage($html, self::$title);
    }

    public function getMainStoreUrl()
    {
        if (isset($_POST[self::$mainStoreUrl]))
        {
                return $this->sanitize($_POST[self::$mainStoreUrl]);
        }
    }

    public function getDBHostNamePost()
    {
        if (isset($_POST[self::$DBhostname]))
        {
                return $this->sanitize($_POST[self::$DBhostname]);
        }
    }

    public function getDBUsernamePost()
    {
        if (isset($_POST[self::$DBusername]))
        {
                return $this->sanitize($_POST[self::$DBusername]);
        }
    }

    public function getDBPasswordPost()
    {
        if (isset($_POST[self::$DBpassword]))
        {
                return $this->sanitize($_POST[self::$DBpassword]);
        }
    }

    public function getDBNamePost()
    {
        if (isset($_POST[self::$DBname]))
        {
                return $this->sanitize($_POST[self::$DBname]);
        }

    }

    /**Removes html tags
     * @return String $data
     */
    private function sanitize($data) {
        return htmlspecialchars(trim($data));
    }

    /**
     * @return position in $GET
     */
    public function isUpdatingSettings()
    {
        return isset($_GET[self::$saveSettings]);
    }

    public function addMainStoreDBSettings()
    {
        try {
            $mainStoreUrl = $this->getMainStoreUrl();
            $dbHost = $this->getDBHostNamePost();
            $dbUsername = $this->getDBUsernamePost();
            $dbPassword = $this->getDBPasswordPost();
            $dbName = $this->getDBNamePost();


            $DBSettings = new MainStoreDBSettings($mainStoreUrl, $dbHost, $dbUsername, $dbPassword, $dbName);
            $this->settingsHandler->addMainStoreDBSettings($DBSettings);
            $this->message = "Main Store Settings were saved successfully!";
        }
        catch (\Exception $e)
        {
            $this->inputIsWrong();
        }
    }


    private function inputIsWrong()
    {
        if(preg_match("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/",$_POST[self::$mainStoreUrl])==false)
        {
            $this->message = "Make sure your main store adress is a correct url. http://example.com";
        }
        else if($_POST[self::$mainStoreUrl]=="")
        {
            $this->message = "Main Store Adress can not be empty";
        }
        else if($_POST[self::$DBhostname]=="")
        {
            $this->message = "Database hostname can not be empty";
        }
        else if($_POST[self::$DBusername]=="")
        {
            $this->message = "Database username can not be emtpy";
        }
        else if($_POST[self::$DBpassword]=="")
        {
            $this->message = "Database password can not be empty";
        }
        else if($_POST[self::$DBname] == "")
        {
            $this->message = "Database name can not be empty";
        }

    }
}