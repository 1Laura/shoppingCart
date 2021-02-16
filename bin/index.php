#!/usr/bin/env php
<?php
require 'vendor/autoload.php';

use app\src\Cart;
use app\src\ProductsReader;
use app\src\Currency;


//user set default currency
$currency = new Currency;
$currencyDisplay = $currency->currencyList();
$inputCurrency = readline("Type number which currency you want to set default: ") . PHP_EOL;

$defaultCurrency = $currency->setCurrency($inputCurrency);
while ($defaultCurrency === '') {
    $inputCurrency = readline("Enter number which currency you want to set default: ") . PHP_EOL;
    $defaultCurrency = $currency->setCurrency($inputCurrency);
}
echo PHP_EOL;
echo "Default currency set: $defaultCurrency" . PHP_EOL;
echo PHP_EOL;


//// all products array
//$products = new ProductsReader();
//$dataArray = $products->txt_parse("bin/data.txt");

//// a list of products is displayed
//print_r("ID " . "Product Name" . ' ' . "Price" . ' ' . "Currency" . PHP_EOL);
//foreach ($dataArray as $product) {
//    //    if ($product->getQuantity() > 0) {
//    $price = $currency->convertCurrency($defaultCurrency, $product->getPrice(), $product->getCurrency());
//    print_r($product->getId() . '. ' . $product->getName() . ', ' . $price . ' ' . $defaultCurrency . ' :  ' . $product->getQuantity() . PHP_EOL);
//    //    }
//}
//echo PHP_EOL;
//
////user selected product
//$inputProductNumberW = readline("Type number which product you want add to cart: ");
//$cartW = new Cart();
//$selectedProductNumberW = $cartW->getSelectedProductId($inputProductNumberW, $dataArray);
//$productSelectedW = $dataArray[$selectedProductNumberW];
//
//print_r($productSelectedW->getName() . " : " . $productSelectedW->getQuantity() . PHP_EOL);
//
//// the quantity of the product selected by the user
//(int)$productQuantityAskedW = readline("Enter the product quantity: ");
//
//$cartArray = [];
//if ($cartW->isQuantityInStock($productSelectedW, $productQuantityAskedW)) {
//    // product remove from warehouse
//    $productSelectedW->setQuantity($productSelectedW->getQuantity() - $productQuantityAskedW);
//
//    echo PHP_EOL;
//    echo "Selected quantity: $productQuantityAskedW" . PHP_EOL;
//    echo PHP_EOL;
//
//    //add to cart
//    if (array_key_exists($selectedProductNumberW, $cartArray)) {
//        $cartArray[$selectedProductNumberW] += $productQuantityAskedW;
//    } else {
//        $cartArray[$selectedProductNumberW] = $productQuantityAskedW;
//    }
//
//}

//reikia paklausti ar nori dar pasirinkti produktu
$wantToChooseProduct = readline("If you want to choose a product - Enter [yes], otherwise enter [no] : ");
echo PHP_EOL;
$cartArray = [];

//jei taip -> produktu listas ir kiekis
if ($wantToChooseProduct == 'yes') {


    while ($wantToChooseProduct == 'yes') {

        // all products array
        $products = new ProductsReader();
        $dataArray = $products->txt_parse("bin/data.txt");


        // a list of products is displayed
        print_r("ID " . "Product Name" . ' ' . "Price" . ' ' . "Currency" . PHP_EOL);
        foreach ($dataArray as $product) {
            $price = $currency->convertCurrency($defaultCurrency, $product->getPrice(), $product->getCurrency());
            print_r($product->getId() . '. ' . $product->getName() . ', ' . $price . ' ' . $defaultCurrency . ' :  ' . $product->getQuantity() . PHP_EOL);
        }
        //  user selected product
        $inputProductNumber = readline("Type number which product you want add to cart: ");
        $cart = new Cart();
        $selectedProductNumber = $cart->getSelectedProductId($inputProductNumber, $dataArray);
        $productSelected = $dataArray[$selectedProductNumber];

        print_r($productSelected->getName() . " : " . $productSelected->getQuantity() . PHP_EOL);

        // the quantity of the product selected by the user
        (int)$productQuantityAsked = readline("Enter the product quantity: ");

//        $cartArray = [];

//        if ($cart->isQuantityInStock($productSelected, $productQuantityAsked)) {
//            // product remove from warehouse
//            $productSelected->setQuantity($productSelected->getQuantity() - $productQuantityAsked);
//
//            echo PHP_EOL;
//            echo "Selected quantity: $productQuantityAsked" . PHP_EOL;
//            echo PHP_EOL;
//
//            //add to cart
//            if (array_key_exists($selectedProductNumber, $cartArray)) {
//                $cartArray[$selectedProductNumber] += $productQuantityAsked;
//            } else {
//                $cartArray[$selectedProductNumber] = $productQuantityAsked;
//            }
//        }


        while ($cart->isQuantityInStock($productSelected, $productQuantityAsked)) {
            // product remove from warehouse
            $productSelected->setQuantity($productSelected->getQuantity() - $productQuantityAsked);

            echo PHP_EOL;
            echo "Selected quantity: $productQuantityAsked" . PHP_EOL;
            echo PHP_EOL;

            //add to cart
            if (array_key_exists($selectedProductNumber, $cartArray)) {
                $cartArray[$selectedProductNumber] += $productQuantityAsked;
            } else {
                $cartArray[$selectedProductNumber] = $productQuantityAsked;
            }
        }


        echo PHP_EOL;
        $wantToChooseProduct = readline("If you want to choose a product - Enter [yes], otherwise enter [no] : ");
        echo PHP_EOL;
    }
} else {
    //jei ne->parodyti krepseli ir paklausti ar nori issimti produktus
    echo "parodyti krepseli";
    print_r($cartArray);
}


//vel paklausti ar nori pasirinkti


//print_r($productSelected);
//print_r($cartArray);
//print_r($dataArray);


echo PHP_EOL;
echo "end";