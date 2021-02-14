#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use src\ProductsReader;
use src\Currency;

//require 'vendor/autoload.php';

$currency = new Currency;
echo "Set currency \n";
$defaultCurrency = $currency->setCurrency();
print_r("Default currency " . $defaultCurrency . PHP_EOL);
echo PHP_EOL;
$products = new ProductsReader();

$dataArray = $products->txt_parse("bin/data.txt");
//print_r($dataArray);


//$products = [];
//foreach ($dataArray as $key => $product) {
//    var_dump($product);
//    $productId = $product->getId();
//    $productName = $product->getName();
//    $productPrice = $product->getPrice();
//    $productCurrency = $product->getCurrency();
//    print_r($productId . '. ' . $productName . ', ' . $productPrice . ', ' . $productCurrency . "\n");
////    var_dump($product);
////    var_dump($key);
////    echo " \n";
////    print_r($product->getPrice());
////    echo " \n";
//}
////print_r($products);


$products = [];
print_r("ID " . "Product Name" . ' ' . "Price" . ' ' . "Currency" . PHP_EOL);
foreach ($dataArray as $key => $product) {
    $productId = $product->getId();
    $productName = $product->getName();
//    $productPrice = $product->getPrice();
    $price = '';
    $currency = '';
    $productCurrency = $product->getCurrency();


    if ($defaultCurrency == 'EUR') {
        if ($productCurrency == 'USD') {
            $price = round($product->getPrice() / 1.14, 2);
            $currency = 'EUR';
        } elseif ($product->getCurrency() == 'GBP') {
            $price = round($product->getPrice() / 0.88, 2);
            $currency = 'EUR';
        } else {
            $price = $product->getPrice();
            $currency = 'EUR';
        }
        // '2' => 'USD',
    } elseif ($defaultCurrency == 'USD') {
        if ($product->getCurrency() == 'EUR') {
            $price = round($product->getPrice() * 1.14, 2);
            $currency = 'USD';
        } elseif ($product->getCurrency() == 'GBP') {
            $price = round($product->getPrice() / (0.88 * 1.14), 2);
            $currency = 'USD';
        } else {
            $price = $product->getPrice();
            $currency = 'USD';
        }
        //'3' => 'GBP'
    } elseif ($defaultCurrency == 'GBP') {
        if ($product->getCurrency() === 'EUR') {
            $price = round($product->getPrice() * 0.88, 2);
            $currency = 'GBP';
        } elseif ($product->getCurrency() === 'USD') {
            $price = round($product->getPrice() * (1.14 * 0.88), 2);
            $currency = 'GBP';
        } else {
            $price = $product->getPrice();
            $currency = 'GBP';
        }
    }

    print_r($productId . '. ' . $productName . ', ' . $price . ' ' . $currency . PHP_EOL);

}
//print_r($products);


//$covertCurrencyDataArr = $currency->convertCurrency($defaultCurrency, $dataArray);
//print_r($covertCurrencyDataArr);