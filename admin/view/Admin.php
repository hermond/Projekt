<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-26
 * Time: 16:28
 * To change this template use File | Settings | File Templates.
 */

namespace view;
require_once('admin/view/AdminHTMLPage.php');

use model\Product;
use model\ProductHandler;
use model\ProductHanlder;
use model\Products;
use model\SettingsHandler;

class Admin {
    /**
     * @var product\model\ProductHandler
     */
    private $productHandlerModel;
    /**
     * @var settings\model\SettingsHandler
     */
    private $settingsHanlderModel;
    /**
     * @var admin\view\AdminHTMLPage
     */
    private $adminHTMLPageView;

    /**
     * @var String for page title
     */
    private static $title = "Home";

    /**
     * @var String for feedback message
     */
    private $message = "";

    /**
     * @var string for edit product feedback message
     */
    private $editmessage = "";

    /**
     * Variable strings for places in $GET
     */
    private static $removeProduct = "removeproduct";
    private static $editProduct = "editproduct";
    private static $settings = "settings";
    private static $dbSettings = "databasesettings";
    private static $productID = "productID";
    private static $addProduct = "addProduct";
    private static $sync = "sync";

    /**
     * Variable strings positions in $POST
     */
    private static $productName = "productname";
    private static $productDescription = "productdescription";
    private static $productUrl = "producturl";
    private static $productImageUrl = "productimageurl";
    private static $productPrice = "price";
    private static $productVAT = "vat";
    private static $submitEdit = "submitedit";
    /**
    * @param String $mainStoreUrl
    */
    public function __construct(ProductHandler $productHandler)
    {
        $this->productHandlerModel = $productHandler;
        $this->adminHTMLPageView = new AdminHTMLPage();
        $this->settingsHanlderModel = new SettingsHandler();
    }

    /**
    * @return String $html
    */
    public function getAdminView()
    {
        $html = $this->getSubMenu();
        if ($this->getCurrentProducts())
        {
            $html .= $this->getCurrentProducts();
        }
        if ($this->isSyncingWithMainStore())
        {
            $html .= $this->getMainStoreProducts();
        }
        if ($this->isEditingProduct())
        {
            $html .= $this->getEditForm();
        }

        return $this->adminHTMLPageView->getAdminHTMLPage($html, self::$title);
    }

    /**
     * @return String $html
     */
    public function getMainStoreProducts()
    {
        $html = "
        <div id='mainstoreproductslist'>
        <h2>All products from your main store</h2>
        <table>
        <tr>
        <th>Name</th>
        <th>Product Url</th>
        <th>Price without VAT</th>
        </tr>";

        $mainStoreProducts = $this->productHandlerModel->getProductsFromMainStore();
        foreach ($mainStoreProducts as $product)
        {
            $html .= "<tr>
         <td>". $product->getName() ."</td>
         <td>". $product->getUrl() . "</td>
         <td>". $product->getPrice() . "</td>
         <td><a href='?admin&sync&" . self::$addProduct . "&". self::$productID . "=" . $product->getProductID() . "'>Add</a></td>
         </tr>";
        }
        $html .= "</table></div>";
        return $html;
    }

    /**
     * @return String $html
     */
    public function getEditForm()
    {
        if($this->getProduct() == null)
        {
           return "";
        }
        $product = $this->getProduct();
        $html = "
        <div id='editproduct'>
        <h2>Edit product</h2>
        <p>".$this->editmessage."</p>
        <form id ='editproductform' action='?admin&editproduct&" . self::$submitEdit . "&". self::$productID . "=" . $product->getProductID() . "' method='POST'>
        <label>Product name</label>
        <input type='text' name='" . self::$productName . "' value='".$product->getName()."'>
        <label>Product description</label>
        <textarea name='" . self::$productDescription . "'>".$product->getDescription()."</textarea>
        <label>Product target Url</label>
        <input type='text' name='" . self::$productUrl . "' value='".$product->getUrl()."'>
        <label>Image Url</label>
        <input type='text' name='" . self::$productImageUrl . "' value='".$product->getImageUrl()."'>
        <label>Product price</label>
        <input type='text' name='" . self::$productPrice . "' value='".$product->getPrice()."'>
        <label>VAT (ie. 1.25 for 25% VAT)</label>
        <input type='text' name='" . self::$productVAT . "' value='".$product->getVAT()."'>
        <input type='submit' name='posted' value='Update product' id='updateproduct'>
      </form>
      </div>
    ";
        return $html;
    }


    /**
     * private functions which return string values in $POST
     */

    private function getProductName()
    {
        if (isset($_POST[self::$productName])) {
            return $this->sanitize($_POST[self::$productName]);
        }

    }

    private function getProductDescription()
    {
        if (isset($_POST[self::$productDescription])) {
            return $this->sanitize($_POST[self::$productDescription]);
        }
    }

    private function getProductUrl()
    {
        if (isset($_POST[self::$productUrl])) {
            return $this->sanitize($_POST[self::$productUrl]);
        }
    }

    private function getProductImageUrl()
    {
        if (isset($_POST[self::$productImageUrl])) {
            return $this->sanitize($_POST[self::$productImageUrl]);
        }
    }

    private function getProductPrice()
    {
        if (isset($_POST[self::$productPrice])) {
            return $this->sanitize($_POST[self::$productPrice]);
        }
    }

    private function getProductVAT()
    {
        if (isset($_POST[self::$productVAT])) {
            return $this->sanitize($_POST[self::$productVAT]);
        }
    }

    /**Removes html tags
     * @return String $data
     */
    private function sanitize($data) {
        return htmlspecialchars(trim($data));
    }
    public function getCurrentProducts()
    {
        $html = "<div id='currentproductslist'>
        <h2>Current products on this site</h2>
        <p>".$this->message."</p>
        <table>
        <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Target Url</th>
        <th>Price with VAT</th>
        </tr>";

        foreach ($this->productHandlerModel->getProducts() as  $product)
        {
         $html .= "<tr>
         <td>". $product->getName() ."</td>
         <td>". substr($product->getDescription(),0,20) ."..</td>
          <td>". $product->getUrl() ."</td>
        <td>". $product->getPrice() * $product->getVAT()."</td>

         <td><a href='?admin&" . self::$removeProduct . "&". self::$productID . "=" . $product->getProductID() . "'>Remove</a></td>
          <td><a href='?admin&" . self::$editProduct . "&". self::$productID . "=" . $product->getProductID() . "'>Edit preferences</a></td>
         </tr>";
        }
        $html .= "</table></div>";

        return $html;
    }
    /**
     * @return product\model\Product $product
     */
    public function getProduct()
    {
        try {
        foreach ($this->productHandlerModel->getProducts() as $product)
        {
            if($product->getProductID() == $this->getProductIdFromQuery()){
                return $product;
            }
        }
        }
        catch (\Exception $e)
        {
            $this->inputIsWrong();
        }
    }

    private function inputIsWrong()
    {

        $this->editmessage = "Something went wrong.";
        if(strlen($_POST[self::$productName]) > 30)
        {
            $this->editmessage = "Product name is too long.";
        }
        else if(strlen($_POST[self::$productDescription]) > 100)
        {
            $this->editmessage = "Product description is too long.";
        }
        else if(strlen($_POST[self::$productUrl]) > 250)
        {
            $this->editmessage = "Product target url is too long";
        }
        else if(strlen($_POST[self::$productImageUrl]) > 250)
        {
            $this->editmessage = "Product image is too long.";
        }
        else if(strlen($_POST[self::$productPrice]) > 100 || !is_numeric($_POST[self::$productPrice]))
        {
            $this->editmessage = "Price is too long or not a numeric value";
        }
        else if(strlen($_POST[self::$productVAT] > 100|| !is_numeric($_POST[self::$productVAT])))
        {
            $this->editmessage = "VAT is too long or not a numeric value";
        }
    }

    /**
     * @return product\model\Product $product
     */
    public function getProductFromMainStore()
    {
        $mainStoreProducts = $this->productHandlerModel->getProductsFromMainStore();
        foreach ($mainStoreProducts  as $product)
        {
            if($product->getProductID() == $this->getProductIdFromQuery()){
                return $product;
            }
        }
    }



    /**
     * @param product\model\Product $product
     */
    public function removeProductFromDB(Product $product)
    {
        try{
        $this->productHandlerModel->removeProduct($product);
        }
        catch (\Exception $e){
            $this->message = "Something went wrong. Take it easy. Don't remove to product too fast.";
        }
    }

    /**
     * @param product\model\Product $product
     */
    public function editProductInDB(Product $product)
    {
        try{
        $editedProduct = new Product($product->getProductID(), $this->getProductName(),
        $this->getProductDescription(),$this->getProductUrl(), $this->getProductImageUrl(),
        $this->getProductPrice(), $this->getProductVAT());

        $this->productHandlerModel->editProduct($editedProduct);
            $this->editmessage = "Product was successfully edited!";
        }
        catch (\Exception $e)
        {
            $this->inputIsWrong();
        }
    }

    /**
     * @return product\model\Product $product
     */
    public function addProductFromMainStore(Product $product)
    {
        $this->productHandlerModel->addProduct($product);
    }

    /**
     * Functions that return positions in $GET
     */
    private function getProductIdFromQuery()
    {
        if (isset($_GET[self::$productID]))
        {
            return $_GET[self::$productID];
        }
    }

    public function isRemovingProduct()
    {
        return isset($_GET[self::$removeProduct]);
    }

    public function isEditingProduct()
    {
        return isset($_GET[self::$editProduct]);
    }

    public function isSubmitEdit()
    {
        return isset($_GET[self::$submitEdit]);
    }

    public function isSyncingWithMainStore()
    {
        return isset($_GET[self::$sync]);
    }

    public function isAddingProduct()
    {
        return isset($_GET[self::$addProduct]);
    }

    public function isSettings()
    {
        return isset($_GET[self::$settings]);
    }

    public function isDBSettings()
    {
        return isset($_GET[self::$dbSettings]);
    }


    /**
     * @return string
     */
    public function getHeader()
    {
        return "<!DOCTYPE html>
        <html>
        <head>
        <title>Admin</title>
        <meta charset='UTF-8'>
        <link rel='stylesheet' type='text/css' href='public/admin.css'>
        </head>

        <body>
        <div id ='header'>
        <img src = './public/images/administration.png' alt='Administration'>
        </div>";
    }

    /**
     * @return string
     */
    private function getSubMenu()
    {
        return "
        <div id='submenu'>
        <a href='?admin&" . self::$sync . "' id='getmainstoreproducts'>Get products from main store</a>
        </div>
        ";
    }

    /**
     * @return string
     */
    public function getFooter()
    {
    return "
    </body>

    </html>";
    }

}