<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-10-24
 * Time: 01:28
 * To change this template use File | Settings | File Templates.
 */

namespace model;


class Product {
    /**
     * @var int|string
     */
    private $productID;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $imageUrl;
    /**
     * @var string
     */
    private $price;
    /**
     * @var string
     */
    private $VAT;

    /**
     * @param int $productID
     * @param $name
     * @param $description
     * @param $url
     * @param $imageUrl
     * @param $price
     * @param $vat
     */
    public function __construct ($productID = 0, $name, $description, $url, $imageUrl, $price, $vat)
    {
        if(!is_numeric($productID))
        {
            throw new \Exception("ProductID is not an int");
        }
        if (!is_string($name) || strlen($name) >30)
        {
            throw new \Exception("Product name is not a string");
        }
        if (!is_string($description) || strlen($description) >100)
        {
            throw new \Exception("Product description is not a string");
        }
        if (!is_string($url) || strlen($url) >250)
        {
            throw new \Exception("Url is not a string");
        }
        if (!is_string($imageUrl) || strlen($imageUrl) >250)
        {
            throw new \Exception("Image url is not a string");
        }
        if (!is_string($vat) || strlen($vat) >100)
        {
            throw new \Exception("VAT is not a string");
        }
        if (!is_string($vat) || strlen($vat) >100)
        {
            throw new \Exception("VAT is not a string");
        }

        $this->productID = $productID;
        $this->name = $name;
        $this->description = $description;
        $this->url = $url;
        $this->imageUrl = $imageUrl;
        $this->price = $price;
        $this->VAT = $vat;
    }
    public function getProductID()
    {
        return $this->productID;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getVAT()
    {
        return $this->VAT;
    }


}

