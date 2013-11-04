<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-24
 * Time: 01:19
 * To change this template use File | Settings | File Templates.
 */

namespace controller;

use model\ProductHandler;
use model\SiteUser;
use view\Admin;
use view\AdminDatabase;
use view\AdminProducts;
use view\AdminSettings;
use view\Frontend;
use view\View;
require_once('application/view/View.php');
require_once ('admin/controller/AdminController.php');
require_once('frontend/controller/FrontendController.php');
require_once('admin/view/Admin.php');
require_once('frontend/view/Frontend.php');
require_once('product/model/ProductHandler.php');
require_once('login/model/SiteUser.php');
require_once('login/view/Login.php');
require_once('login/controller/LoginController.php');

//require_once('view/AdminDatabase.php');
//require_once('view/AdminSettings.php');


class DoApplication {
    /**
     * @var \view\View
     */
    private $view;
    /**
     * @var AdminController
     */
    private $adminController;
    /**
     * @var FrontendController
     */
    private $frontendController;
    /**
     * @var \view\Admin
     */
    private $adminView;
    /**
     * @var \view\Frontend
     */
    private $frontendView;
    /**
     * @var \model\ProductHandler
     */
    private $productHandler;
    /**
     * @var \model\SiteUser
     */
    private $siteUserModel;
    /**
     * @var LoginController
     */
    private $loginController;



    public function __construct()
    {
        $this->view = new View();
        $this->productHandler = new ProductHandler();
        $this->adminView = new Admin($this->productHandler);
        $this->frontendView = new Frontend($this->productHandler);
        $this->adminController = new AdminController($this->adminView);
        $this->frontendController = new FrontendController($this->frontendView);
        $this->loginController = new LoginController();
        $this->siteUserModel = new SiteUser();



    }

    public function doApplication(){


    try{
        if($this->view->showAdminPage())
        {
            $this->loginController->doLogin();

            if ($this->siteUserModel->isLoggedIn())
            {
            return $this->adminController->doAdmin();
            }
            else
            {
                return $this->loginController->doLogin();
            }
        }
        else
        {
            return $this->frontendController->doFrontend();
        }

    }
    catch (\Exception $e) {
        return "Something went wrong";
    }

    }

}