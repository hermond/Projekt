<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-26
 * Time: 16:29
 * To change this template use File | Settings | File Templates.
 */

namespace view;

require_once('admin/model/SettingsHandler.php');
require_once('admin/model/Settings.php');
use model\Setting;
use model\SettingHandler;
use model\Settings;
use model\SettingsHandler;

class AdminSettings {

    /**
     * @var string
     */
    private static $title = "Site Settings";
    /**
     * strings for position in $POST
     */
    private static $pageTitle = "pagetitle";
    private static $heading1 = "heading1";
    private static $introText = "introtext";
    private static $metaDescription = "metadescription";
    private static $metaKeywords = "metakeywords";
    private static $showPrice = "showprice";
    private static $nofollow = "nofollow";
    private static $language = "language";

    /**
     * @var string for position in $GET
     */
    private static $updateSettings = "updatesettings";

    /**
     * @var AdminHTMLPage
     */
    private $adminHTMLPageView;
    /**
     * @var \model\SettingsHandler
     */
    private $settingsHandler;

    /**
    * @var String
     */
    private $message;

    public function __construct(){

      $this->adminHTMLPageView = new AdminHTMLPage();
      $this->settingsHandler = new SettingsHandler();

    }

    /**
     * @param Settings $settings
     * @return String
     */
    public function getAdminSettingsView(Settings $settings)
    {
        $html = "
        <div id='sitesettings'>
        <p>".$this->message."</p>
        <form id='sitesettingsform' action='?admin&settings&" . self::$updateSettings . "' method='POST'>
        <table>
        <tr>
        <td><label>Page title</label>
        <td><input type='text' name='" . self::$pageTitle . "' value='".$settings->getPageTitle()."'>
        </tr>
        <tr>
        <td><label>Heading 1</label>
        <td><input type='text' name='" . self::$heading1 . "' value='".$settings->getHeading1()."'>
        </tr>
        <tr>
        <td><label>Intro text</label>
        <td><textarea name='" . self::$introText . "'>".$settings->getIntroText()."'</textarea>
        </tr>
        <tr>
        <td><label>Meta Language</label>
        <td><input type='text' name='" . self::$language . "' value='".$settings->getLanguage()."'>
        </tr>
        <tr>
        <td><label>Meta Description</label>
        <td><textarea name='" . self::$metaDescription . "'>".$settings->getMetaDescription()."</textarea>
        </tr>
        <tr>
        <td><label>Meta Keywords</label>
        <td><input type='text' name='" . self::$metaKeywords . "' value='".$settings->getMetaKeywords()."'>
        </tr>
        <tr>
        <td><label>Show price</label>
        <td><input type='checkbox' name='" . self::$showPrice . "'" .$settings->getShowPriceAsString().">
        </tr>
        <tr>
        <td><label>Set target links as nofollow</label>
        <td><input type='checkbox' name='" . self::$nofollow . "'" .$settings->getNofollowAsString().">
        </tr>
        <tr>
        <td>
        <td><input type='submit' name='posted' value='Save settings'>
        </tr>
        </table>
        </form>
        </div>
        ";
        return $this->adminHTMLPageView->getAdminHTMLPage($html, self::$title);
    }

    /**
     * fuctions that returns different positions in $POST
     */

    public function getPageTitle()
    {
        if(isset($_POST[self::$pageTitle])) {
            return $this->sanitize($_POST[self::$pageTitle]);
        }
    }

    public function getHeading1()
    {
        if(isset($_POST[self::$heading1])) {
            return $this->sanitize($_POST[self::$heading1]);
        }
    }

    public function getIntroText()
    {
        if(isset($_POST[self::$introText])) {
            return $this->sanitize($_POST[self::$introText]);
        }
    }

    public function getMetaDescription()
    {
        if(isset($_POST[self::$metaDescription])) {
            return $this->sanitize($_POST[self::$metaDescription]);
        }
    }

    public function getMetaKeywords()
    {
        if(isset($_POST[self::$metaKeywords])) {
            return $this->sanitize($_POST[self::$metaKeywords]);
        }
    }

    public function getShowPrice()
    {
        if(isset($_POST[self::$showPrice])) {
            if (strtolower($_POST[self::$showPrice]) == 'on')
            {
                return 1;
            }
            else {
                return 0;
            }
        }
    }

    public function getNofollow()
    {
        if(isset($_POST[self::$nofollow])) {
            if (strtolower($_POST[self::$nofollow]) == 'on')
            {
                return 1;
            }
            else {
                return 0;
            }
        }
    }

    public function getLanguage()
    {
        if(isset($_POST[self::$language])) {

         return $this->sanitize($_POST[self::$language]);
        }
    }


    /**Removes html tags
     * @return String $data
     */
    private function sanitize($data) {
        return htmlspecialchars(trim($data));
    }

    /**
     * @return bool
     */
    public function isUpdatingSettings()
    {
        return isset($_GET[self::$updateSettings]);
    }


    public function updateSettings()
    {

        try {
            $pageTitle = $this->getPageTitle();
            $heading1 = $this->getHeading1();
            $introText = $this->getIntroText();
            $language = $this->getLanguage();
            $metaDescription = $this->getMetaDescription();
            $metaKeywords = $this->getMetaKeywords();
            $nofollow = $this->getNofollow();
            $showPrice = $this->getShowPrice();



            $settings = new Settings($pageTitle, $heading1, $introText, $language, $metaDescription,
            $metaKeywords, $nofollow, $showPrice);
            $this->settingsHandler->updateSettings($settings);
            $this->message = "Settings were saved successfully!";
        }
        catch (\Exception $e)
        {
            $this->inputIsWrong();
        }
    }

    private function inputIsWrong()
    {

        $this->message = "Something went wrong when you tried to save. Settings are not saved";
        if(strlen($_POST[self::$pageTitle]) > 70)
        {
            $this->message = "Page title is too long. Search engines will only display 70 cars.";
        }
        else if(strlen($_POST[self::$heading1])>64)
        {
            $this->message = "Heading1 is too long. More than 70 chars is bad for SEO.";
        }
        else if(strlen($_POST[self::$introText])>1000)
        {
            $this->message = "Intro text is too long. Only 1000 chars are allowed.";
        }
        else if(strlen($_POST[self::$language])>8)
        {
            $this->message = "Meta language is too long. It should be short like sv, en-gb, es";
        }
        else if(strlen($_POST[self::$metaDescription])>150)
        {
            $this->message = "Meta descrption is too long. Search engines will only display 70 cars.";
        }
        else if(strlen($_POST[self::$metaKeywords]) > 150)
        {
            $this->message = "You have too many meta keywords. Try to use only your best ones.";
        }
    }
    }