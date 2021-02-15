#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use src\ProductsReader;
use src\Currency;

//require 'vendor/autoload.php';

//user set default currency==========================================================================
$currency = new Currency;
$list = $currency->currencyList();
$inputCurrency = readline("Type number which currency you want to set default: ") . PHP_EOL;
$defaultCurrency = $currency->setCurrency($inputCurrency);

while (!empty($defaultCurrency)) {
    $inputCurrency = readline("Type number which currency you want to set default: ") . PHP_EOL;
    $defaultCurrency = $currency->setCurrency($inputCurrency);
}

print_r("Default currency " . $defaultCurrency . PHP_EOL);

// all products array==================================================================================
$products = new ProductsReader();
$dataArray = $products->txt_parse("bin/data.txt");


// a list of products is displayed ======================================================================
print_r("ID " . "Product Name" . ' ' . "Price" . ' ' . "Currency" . PHP_EOL);

foreach ($dataArray as $product) {
    if ($product->getQuantity() > 0) {
        $price = $currency->convertCurrency($defaultCurrency, $product->getPrice(), $product->getCurrency());
        print_r($product->getId() . '. ' . $product->getName() . ', ' . $price . ' ' . $defaultCurrency . ' :  ' . $product->getQuantity() . PHP_EOL);
    }
}


//user selected product and quantity ===============================================================
$inputProductNumber = readline("Type number which product you want add to cart: ");
$cart = new \src\Cart();
$selectedProductNumber = $cart->getSelectedProductId($inputProductNumber, $dataArray);
$productSelected = $dataArray[$selectedProductNumber];

print_r($productSelected);
print_r($productSelected->getName() . PHP_EOL);
print_r($productSelected->getQuantity() . PHP_EOL);


(int)$productQuantityAsked = readline("Enter the product quantity: ");

$cartArray = [];

if ($cart->isQuantityInStock($productSelected, $productQuantityAsked)) {
    $productSelected->setQuantity($productSelected->getQuantity() - $productQuantityAsked);

    //add to cart ==============================================================================================

    if (array_key_exists($selectedProductNumber, $cartArray)) {
        $cartArray[$selectedProductNumber] += $productQuantityAsked;
    } else {
        $cartArray[$selectedProductNumber] = $productQuantityAsked;
    }


}
print_r($cartArray);
print_r($dataArray);


echo PHP_EOL;
