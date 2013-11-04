<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-28
 * Time: 15:59
 * To change this template use File | Settings | File Templates.
 */

namespace model;
require_once('admin/model/SettingsDAL.php');

class SettingsHandler {
    /**
     * @var admin\model\SettingsDAL
     */
    private $settingsDAL;


    public function __construct(){

        $this->settingsDAL = new SettingsDAL();

    }

    public function updateSettings(Settings $settings)
    {

        $this->settingsDAL->updateSettings($settings);

    }

    public function getSettings()
    {
        return $this->settingsDAL->getSettings();
    }


       /*Settings handling for Main Store Database */
    public function addMainStoreDBSettings(MainStoreDBSettings $dbSettings)
    {
        $this->settingsDAL->addMainStoreDBSettings($dbSettings);
    }

    public function getMainStoreDBSetting(){
        return $this->settingsDAL->getMainStoreDBSettings();
    }
}