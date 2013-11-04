<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-28
 * Time: 15:59
 * To change this template use File | Settings | File Templates.
 */

namespace model;


class Settings {

    /**
     * @var String
     */
    private $pageTitle;
    /**
     * @var String
     */
    private $introText;
    /**
     * @var String
     */
    private $language;
    /**
     * @var String
     */
    private $metaDescription;
    /**
     * @var String
     */
    private $metaKeywords;
    /**
     * @var Int
     */
    private $nofollow;
    /**
     * @var Int
     */
    private $showPrice;

    /**
     * @param String $pageTitle
     * @param String $heading1
     * @param String $introText
     * @param String $language
     * @param String $metaDescription
     * @param String $metaKeywords
     * @param Int $nofollow
     * @param Int $showPrice
     * @throws Exception If validation fails
     */


    public function __construct($pageTitle, $heading1, $introText, $language,
    $metaDescription, $metaKeywords, $nofollow, $showPrice)
    {
        if (!is_string($pageTitle) || strlen($pageTitle) > 70) {
            throw new \Exception("Page title is not a string or too long");
        }
        if (!is_string($heading1) || strlen($heading1) > 64) {
            throw new \Exception("heading 1 is not a string or too long");
        }
        if (!is_string($introText) || strlen($introText) > 1000) {
            throw new \Exception("Intro text is not a string or too long.");
        }
        if (!is_string($language) || strlen($language) > 10) {
            throw new \Exception("Meta language is not a string or too long.");
        }
        if (!is_string($metaDescription) || strlen($metaDescription) > 150) {
            throw new \Exception("Meta description is not a string or too long.");
        }
        if (!is_string($language) || strlen($language) > 150) {
            throw new \Exception("Meta keywords is not a string or too long.");
        }
        if (!is_int($nofollow)) {
            throw new \Exception("nofollow is not an int.");
        }
        if (!is_int($showPrice)) {
            throw new \Exception("showPrice is not an int.");
        }
        $this->pageTitle = $pageTitle;
        $this->heading1 = $heading1;
        $this->introText = $introText;
        $this->language = $language;
        $this->metaDescription = $metaDescription;
        $this->metaKeywords = $metaKeywords;
        $this->nofollow = $nofollow;
        $this->showPrice = $showPrice;
    }

    public function getPageTitle()
    {
        return $this->pageTitle;
    }
    public function getHeading1()
    {
        return $this->heading1;
    }

    public function getIntroText()
    {
        return $this->introText;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    public function getNofollow()
    {
        return $this->nofollow;
    }

    public function getShowPrice()
    {
        return $this->showPrice;
    }

    public function getShowPriceAsString()
    {
        if ($this->showPrice == 1)
        {
            return "checked";
        }
        else {
            return "";
        }
    }
    public function getNofollowAsString()
    {
        if ($this->nofollow == 1)
        {
            return "checked";
        }
        else {
            return "";
        }
    }





}