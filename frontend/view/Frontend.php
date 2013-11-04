<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-26
 * Time: 16:29
 * To change this template use File | Settings | File Templates.
 */

namespace view;


use model\ProductHandler;
use model\Products;
use model\Settings;

class Frontend {

    /**
     * @var \model\ProductHandler
     */
    private $productHandler;

    /**
     * @param ProductHandler $productHandler
     */
    public function __construct(ProductHandler $productHandler)
    {
        $this->productHandler = $productHandler;
    }

    /**
     * @param Settings $settings
     * @return string $html
     */
    public function getFrontendPage(Settings $settings)
    {
     $html = $this->getHeader($settings);
     $html .= $this->getBody($settings);
     $html .= $this->getFooter($settings);

    return $html;
    }

    /**
     * @param Settings $settings
     * @return string
     */
    public function getHeader(Settings $settings)
    {
        return
        "<!DOCTYPE html>
        <html>
        <head>
        <title>".$settings->getPageTitle()."</title>
        <meta charset='UTF-8'>
        <meta http-equiv='content-language' content='".$settings->getLanguage()."'>
        <meta name='description' content='".$settings->getMetaDescription()."'>
        <meta name='keywords' content='".$settings->getMetaKeywords()."'>
        <link rel='stylesheet' type='text/css' href='public/frontend.css'>
        </head>

        <body>";

    }

    /**
     * @param Settings $settings
     * @return string
     */
    public function getBody(Settings $settings)
    {
        return "
        <div id='container'>
        <div id='header'>
        <h1>".$settings->getHeading1()."</h1>
        </div>
        <p id='bodytext'>".$settings->getIntroText()."<p>
        ".$this->getProducts($settings)."
        </div>";
    }

    /**
     * @param Settings $settings
     * @return string
     */
    public function getProducts(Settings $settings){

        $html = "";

        $html .= "<div id='productswrapper'>";

        foreach ($this->productHandler->getProducts() as $product)
        {
            $html .= "<div class='product'>";
            $html .= "<img src='". $product->getImageUrl() ."'/>";
            $html .= "<h2>" . $product->getName() ."</h2>";
            $html .= "<p class='productdescription'>" . $product->getDescription() . "</p>";

            if ($settings->getShowPrice() == 1){
            $html .= "<p class='price'>" . $product->getPrice() . ":-</p>";
            }

            $relnofollow = "";
            if ($settings->getNofollow() == 1){
            $relnofollow = "rel='nofollow'";
            }
            $html .= "<p><a href='" . $product->getUrl() . "' ".$relnofollow." class='targeturl'>Visit Store </a></p>";

            $html .= "</div>";


        }
        return $html;
    }

    /**
     * @param Settings $settings
     * @return string
     */
    public function getFooter(Settings $settings)
    {
        return "
        <div id='footer'>
        <p id='footertext'>&copy;".$settings->getPageTitle()."</p>
        </div>
        </body>
        </html>
        ";
    }


}