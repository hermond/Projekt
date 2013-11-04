<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-27
 * Time: 01:27
 * To change this template use File | Settings | File Templates.
 */

namespace controller;


use model\SettingsHandler;
use view\Frontend;

class FrontendController {
    /**
     * @var \view\Frontend
     */
    private $frontendView;
    /**
     * @var \model\SettingsHandler
     */
    private $settingsHandler;

    /**
     * @param Frontend $frontendView
     */
    public function __construct(Frontend $frontendView)
    {
        $this->frontendView = $frontendView;
        $this->settingsHandler = new SettingsHandler();
    }



    public function doFrontend()
    {

        return $this->frontendView->getFrontendPage($this->settingsHandler->getSettings());

    }

}