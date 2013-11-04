<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-26
 * Time: 15:10
 * To change this template use File | Settings | File Templates.
 */


namespace model;
require_once('product/model/Product.php');
require_once('common/model/DALBase.php');

class productDAL extends DALBase{

    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        $statement = parent::getDBConnection()->prepare("INSERT INTO Product (Name, Description, Url, ImageUrl, Price, VAT)
        VALUES (:name, :description, :url, :imageUrl, :price, :vat)");

        $statement->bindParam(':name', $product->getName(), \PDO::PARAM_STR);
        $statement->bindParam(':description', $product->getDescription(), \PDO::PARAM_STR);
        $statement->bindParam(':url', $product->getUrl(), \PDO::PARAM_STR);
        $statement->bindParam(':imageUrl', $product->getImageUrl(), \PDO::PARAM_STR);
        $statement->bindParam(':price', $product->getPrice(), \PDO::PARAM_STR);
        $statement->bindParam(':vat', $product->getVAT(), \PDO::PARAM_STR);
        $statement->execute();

    }

    /**
     * @return array
     */
    public function getProducts() {
        $statement = parent::getDBConnection()->prepare("SELECT idProduct, Name, Description, Url, ImageUrl, Price, VAT FROM Product");


        $statement->execute();

        $products = array();

        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            try {

                $products[] = new Product($row['idProduct'], $row['Name'], $row['Description'], $row['Url'], $row['ImageUrl'], $row['Price'], $row['VAT']);

            }

            catch (\Exception $e) {

            }

        }

        return $products;
    }

    /**
     * @param Product $product
     */
    public function removeProduct(Product $product)
    {
        $statement = parent::getDBConnection()->prepare("DELETE FROM Product WHERE idProduct = :productID");
        $productID  = $product->getProductID();
        $statement->bindParam(':productID', $productID, \PDO::PARAM_INT);
        $statement->execute();

    }

    /**
     * @param Product $product
     */
    public function editProduct(Product $product)
    {
       $statement = parent::getDBConnection()->prepare("UPDATE Product SET Name=:name, Description = :description,
       Url = :url, ImageUrl = :imageUrl, Price = :price, VAT = :vat WHERE idProduct = :productID");
       $statement->bindParam(':name', $product->getName(), \PDO::PARAM_STR);
       $statement->bindParam(':description', $product->getDescription(), \PDO::PARAM_STR);
       $statement->bindParam(':url', $product->getUrl(), \PDO::PARAM_STR);
       $statement->bindParam(':imageUrl', $product->getImageUrl(), \PDO::PARAM_STR);
       $statement->bindParam(':price', $product->getPrice(), \PDO::PARAM_STR);
       $statement->bindParam(':vat', $product->getVAT(), \PDO::PARAM_STR);
        $statement->bindParam(':productID', $product->getProductID(), \PDO::PARAM_INT);
       $statement->execute();


    }
}