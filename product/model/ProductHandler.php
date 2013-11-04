<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-24
 * Time: 02:46
 * To change this template use File | Settings | File Templates.
 */

namespace model;

require_once('product/model/ProductDAL.php');
require_once('product/model/MainStoreProductDAL.php');

class ProductHandler {

    /**
     * @var ProductDAL
     */
    private $productDAL;
    /**
     * @var SettingsHandler
     */
    private $settingsHandler;
    /**
     * @var MainStoreProductDAL
     */
    private $mainStoreProductDAL;

    public function __construct()
    {
     $this->productDAL = new ProductDAL();
     $this->settingsHandler = new SettingsHandler();
     $this->mainStoreProductDAL = new MainStoreProductDAL($this->settingsHandler->getMainStoreDBSetting());

    }

    public function getProducts()
    {
        return $this->productDAL->getProducts();
    }
    public function removeProduct(Product $product)
    {
        $this->productDAL->removeProduct($product);
    }

    public function editProduct($product)
    {
        $this->productDAL->editProduct($product);
    }

    public function addProduct(Product $product)
    {
        $mainStoreProduct = $this->mainStoreProductDAL->getProductFromMainStore($product);
        $this->productDAL->addProduct($mainStoreProduct);
    }

   public function getProductsFromMainStore()
    {
        return $this->mainStoreProductDAL->getProductsFromMainStore();

    }





}