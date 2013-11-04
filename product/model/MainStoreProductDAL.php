<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-30
 * Time: 15:44
 * To change this template use File | Settings | File Templates.
 */

namespace model;


class MainStoreProductDAL {

    /**
     * @var String
     */
    private $mainStoreUrl;
    /**
     * @var String
     */
    private $hostname;
    /**
     * @var String
     */
    private $username;
    /**
     * @var String
     */
    private $password;
    /**
     * @var String
     */
    private $name;
    /**
     * @var string
     */
    private static $charset = "UTF8";

    /**
     * @param MainStoreDBSettings $mainStoreDBSettings
     */
    public function __construct(MainStoreDBSettings $mainStoreDBSettings)
  {
      $this->mainStoreUrl = $mainStoreDBSettings->getMainStoreUrl();
      $this->hostname = $mainStoreDBSettings->getDBHost();
      $this->username = $mainStoreDBSettings->getDBUsername();
      $this->password = $mainStoreDBSettings->getDBPassword();
      $this->name = $mainStoreDBSettings->getDBName();
  }

    private function getMainStoreDBConnection()
    {
    try {
            $pdo = new \PDO("mysql:host=" . $this->hostname . ";dbname=" . $this->name . ";charset=" . self::$charset
                , $this->username, $this->password);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE,\PDO::FETCH_ASSOC);
    }catch (\Exception $e){
        die('Cannot connect to databse. Details:'.$e->getMessage());
    }
        return $pdo;
    }


    public function getProductsFromMainStore()
    {
        $statement = $this->getMainStoreDBConnection()->prepare("
        select product.product_id, product.image, product.price, product_description.name
        from product
        inner join product_description
        on product_description.product_id = product.product_id");


        $statement->execute();

        $products = array();

        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            try {

                $products[] = new Product($row['product_id'], $row['name'], "", $this->mainStoreUrl, $this->mainStoreUrl."/image/".$row['image'], $row['price'], "");

            }

            catch (\Exception $e) {

            }

        }

        return $products;
    }

    public function getProductFromMainStore(Product $product)
    {
        $statement = $this->getMainStoreDBConnection()->prepare("
        select product.product_id, product.image, product.price, product_description.name
        from product
        inner join product_description
        on product_description.product_id = product.product_id
        where product.product_id = :productID");
        $productID  = $product->getProductID();
        $statement->bindParam(':productID', $productID, \PDO::PARAM_INT);
        $statement->execute();

        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            try {

                $product = new Product($row['product_id'], $row['name'], "", $this->mainStoreUrl, $this->mainStoreUrl."/image/".$row['image'], $row['price'], "");

            }

            catch (\Exception $e) {

            }
            return $product;
        }
    }
}