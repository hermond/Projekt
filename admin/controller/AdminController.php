<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-27
 * Time: 00:55
 * To change this template use File | Settings | File Templates.
 */

namespace controller;

require_once('admin/view/AdminDatabase.php');
require_once('admin/view/AdminSettings.php');

use model\MainStoreDAL;
use model\ProductHandler;
use model\SettingsHandler;
use view\Admin;
use view\AdminDatabase;
use view\AdminSettings;

class AdminController {

    /**
     * @var admin\view\Admin
     */
    private $adminView;
    /**
     * @var admin\view\AdminDatabase
     */
    private $adminDatabaseView;
    /**
     * @var admin\view\AdminSettings
     */
    private $adminSettingsView;

    /**
     * @var admin\model\SettingsHandler
     */
    private $settingsHandler;
    /**
     * @var product\model\ProductHandler
     */
    private $productHandler;

    public function __construct(Admin $adminView)
    {
        $this->adminView = $adminView;
        $this->adminDatabaseView = new AdminDatabase();
        $this->adminSettingsView = new AdminSettings();
        $this->settingsHandler = new SettingsHandler();
        $this->productHandler = new ProductHandler();
    }


    public function doAdmin()
    {

        if($this->adminView->isSettings())
        {
            if ($this->adminSettingsView->isUpdatingSettings())
            {
                $this->adminSettingsView->updateSettings();
            }
            return $this->adminSettingsView->getAdminSettingsView($this->settingsHandler->getSettings());
        }
        else if ($this->adminView->isDBSettings())
        {
            if ($this->adminDatabaseView->isUpdatingSettings())
            {
                $this->adminDatabaseView->addMainStoreDBSettings();
            }
            return $this->adminDatabaseView->getDBSettingsForm($this->settingsHandler->getMainStoreDBSetting());
        }
        else {
            if ($this->adminView->isRemovingProduct())
            {
                if ($this->adminView->getProduct() != null)
                {
                $this->adminView->removeProductFromDB($this->adminView->getProduct());
                }
                else{
                    return $this->adminView->getAdminView();
                }
            }
            if ($this->adminView->isSubmitEdit())
            {
                if ($this->adminView->getProduct() != null)
                $this->adminView->editProductInDB($this->adminView->getProduct());
            }
            if ($this->adminView->isAddingProduct())
            {
                $this->adminView->addProductFromMainStore($this->adminView->getProductFromMainStore());
            }

            return $this->adminView->getAdminView();
        }


    }
}