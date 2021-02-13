#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use src\ProductsReader;
use src\Shop;

//require 'vendor/autoload.php';

$shop = new Shop;
echo "Set currency \n";
$defaultCurrency = $shop->setCurrency();
//print_r($defaultCurrency);
echo $defaultCurrency . "\n";
//$shop->getDataFromTextFile();
//echo "Display Data from text file \n";
//$shop->displayAllDataFromTextFile();

$products = new ProductsReader();

$dataArray = $products->csv_parse("bin/data.txt");
//print_r($products->getId());
$products = [];
foreach ($dataArray as $key => $product) {
    $productId = $product->getId();
    $productName = $product->getName();
    $productPrice = $product->getPrice();
    $productCurrency = $product->getCurrency();
    print_r($productId . '. ' . $productName . ', ' . $productPrice . ', ' . $productCurrency . "\n");
//    var_dump($product);
//    var_dump($key);
//    echo " \n";
//    print_r($product->getPrice());
//    echo " \n";
}
//print_r($products);
