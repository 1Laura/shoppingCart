<?php


namespace app\src;


class Cart
{

    public function getSelectedProductId($inputProductNumber, $productsFromWarehouse)
    {
        if (!array_key_exists($inputProductNumber, $productsFromWarehouse)) {
            echo "You need to choose a product" . PHP_EOL;
            $inputProductNumber = readline("Type number which product you want add to cart: ");
        }
        return $inputProductNumber;
    }

    public function isQuantityInStock($warehouseProduct, $quantityAsked)
    {


        if ($warehouseProduct->getQuantity() > 0) {
            if ($warehouseProduct->getQuantity() >= $quantityAsked) {
                return true;
            } else {
                echo "You need to choose a quantity less than " . $warehouseProduct->getQuantity() . PHP_EOL;
                return false;
            }
        } else {
            print_r($warehouseProduct->getQuantity());
            echo "Sorry, product is out of stock" . PHP_EOL;
            return false;
        }
    }

    public function isProductIdIs($inputProductId, $allProducts)
    {
        if (array_key_exists($inputProductId, $allProducts)) {
            return true;
        }
        return false;

    }


}