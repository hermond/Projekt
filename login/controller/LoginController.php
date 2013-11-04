<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-11-02
 * Time: 16:47
 * To change this template use File | Settings | File Templates.
 */

namespace controller;


use model\SiteUser;
use view\Login;

class LoginController {

    /**
     * @var \view\Login
     */
    private $loginView;

    /**
     * @var \model\SiteUser
     */
    private $siteUserModel;

    function __construct ()
    {
        $this->loginView = new Login();
        $this->siteUserModel = new SiteUser();
    }

    public function doLogin()
    {
      if($this->loginView->isLoggingOut())
        {
            return $this->validateLogout();
        }
        else if ($this->loginView->isLoggingIn())
        {
              return $this->validateLogin();
        }
        return $this->loginView->getLoginPage();
    }

    private function validateLogout()
    {
        if ($this->siteUserModel->isLoggedIn()){
            $this->siteUserModel->unsetSession();
        }

        return $this->loginView->getLoginPage();
    }

    private function validateLogin()
    {
        try{
            $username = $this->loginView->getUsernamePost();
            $password = $this->loginView->getPasswordPost();
        }
        catch (\Exception $e)
        {
            return $this->loginView->getLoginPage();
        }

        try {
            $this->siteUserModel->userValidation($username, $password);

        }
        catch (\Exception $e)
        {
            $this->loginView->setFeedbackMessage();
            return $this->loginView->getLoginPage();
        }
    }
}