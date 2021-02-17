#!/usr/bin/env php
<?php
require 'vendor/autoload.php';

use app\src\Cart;
use app\src\ProductsReader;
use app\src\Currency;

$currency = new Currency;
$cart = new Cart();
$products = new ProductsReader();


//user set default currency
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
//$inputProductNumber = readline("Type number which product you want add to cart: ");
//$cart = new Cart();
//$selectedProductNumber = $cart->getSelectedProductId($inputProductNumber, $dataArray);
//$productSelected = $dataArray[$selectedProductNumber];
//
//print_r($productSelected->getName() . " : " . $productSelected->getQuantity() . PHP_EOL);
//
//// the quantity of the product selected by the user
//(int)$productQuantityAsked = readline("Enter the product quantity: ");
//
//$cartArray = [];
//if ($cart->isQuantityInStock($productSelected, $productQuantityAskedW)) {
//    // product remove from warehouse
//    $productSelected->setQuantity($productSelected->getQuantity() - $productQuantityAsked);
//
//    echo PHP_EOL;
//    echo "Selected quantity: $productQuantityAsked" . PHP_EOL;
//    echo PHP_EOL;
//
//    //add to cart
//    if (array_key_exists($selectedProductNumber, $cartArray)) {
//        $cartArray[$selectedProductNumber] += $productQuantityAsked;
//    } else {
//        $cartArray[$selectedProductNumber] = $productQuantityAsked;
//    }
//
//}

//reikia paklausti ar nori pasirinkti produktu
$wantToChooseProduct = readline("If you want to choose a product - Enter [yes], otherwise enter [no] : ");
echo PHP_EOL;
$cartArray = [];
// all products array
$dataArray = $products->txt_parse("bin/data.txt");

if ($wantToChooseProduct == 'yes') {
    //jei taip, jei nori pasirinkti produkta
    // -> produktu listas ir kiekis
    while ($wantToChooseProduct == 'yes') {

        // a list of products is displayed
        print_r("ID " . "Product Name" . ' ' . "Price" . ' ' . "Currency" . PHP_EOL);
        foreach ($dataArray as $product) {
            $price = $currency->convertCurrency($defaultCurrency, $product->getPrice(), $product->getCurrency());
            print_r($product->getId() . '. ' . $product->getName() . ', ' . $price . ' ' . $defaultCurrency . ' :  ' . $product->getQuantity() . PHP_EOL);
        }
        echo PHP_EOL;
        //  user selected product
        $inputProductNumber = readline("Type number which product you want add to cart: " . PHP_EOL);
        $selectedProductNumber = $cart->getSelectedProductId($inputProductNumber, $dataArray);
        $productSelected = $dataArray[$selectedProductNumber];
        print_r($productSelected->getName() . " : " . $productSelected->getQuantity() . PHP_EOL);

        // the quantity of the product selected by the user
        (int)$productQuantityAsked = readline("Enter the product quantity: " . PHP_EOL);
        if ($cart->isQuantityInStock($productSelected, $productQuantityAsked)) {
            // jei kiekis yra warehouse
//            while ($cart->isQuantityInStock($productSelected, $productQuantityAsked)) {
            // klausk kol kiekis bus reikiamas
            // product remove from warehouse
            $productSelected->setQuantity($productSelected->getQuantity() - $productQuantityAsked);
            echo PHP_EOL;
            echo "Selected quantity: $productQuantityAsked" . PHP_EOL;

            //add to cart
            if (array_key_exists($selectedProductNumber, $cartArray)) {
                $cartArray[$selectedProductNumber] += $productQuantityAsked;
            } else {
                $cartArray[$selectedProductNumber] = $productQuantityAsked;
            }
        }
//        echo PHP_EOL;
        $wantToChooseProduct = readline("If you want to choose a product - Enter [yes], otherwise enter [no] :  " . PHP_EOL);
        echo PHP_EOL;
    }
} else {
    echo PHP_EOL;
    echo "Thank you!";
}
if ($wantToChooseProduct == 'no') {
    //jei nenori pasirinkti produktu
    //->parodyti krepseli
    $totalBalance = 0.00;
    echo "You carts: " . PHP_EOL;
    foreach ($cartArray as $key => $cartProduct) {
        $cartProductQuantity = $cartArray[$key];
        $cartProductPrice = $currency->convertCurrency($defaultCurrency, $dataArray[$key]->getPrice(), $dataArray[$key]->getCurrency());
        print_r($dataArray[$key]->getName() . ' , ' . $cartProductQuantity . ' , ' . $cartProductPrice . PHP_EOL);
        $totalBalance += $cartProductPrice * $cartProductQuantity;
    }
    print_r("Total balance:  " . $totalBalance . PHP_EOL);
    //paklausti ar nori issimti produktus
    echo PHP_EOL;
    $wantToRemoveProduct = readline("If you want to remove a product - Enter [yes], otherwise enter [no] : " . PHP_EOL);
    echo PHP_EOL;
    //jei taip,
    if ($wantToRemoveProduct == 'yes') {
//        print_r($cartArray);
        // listas krepselio produktu
        foreach ($cartArray as $key => $cartProduct) {
            $cartProductName = $dataArray[$key]->getName();
            $cartProductQuantity = $cartArray[$key];
            $cartProductPrice = $currency->convertCurrency($defaultCurrency, $dataArray[$key]->getPrice(), $dataArray[$key]->getCurrency());
            $totalBalance += $cartProductPrice * $cartProductQuantity;
            echo $key . ' . ' . $cartProductName . ' : ' . $cartProductPrice . ' * ' . $cartProductQuantity . ' = ' . $cartProductPrice * $cartProductQuantity . PHP_EOL;
        }

        //paklausti kuri produkta nori isimti
        echo PHP_EOL;
        $whichProductSelectedId = readline("Type number which product you want to remove from cart  : " . PHP_EOL);
        echo PHP_EOL;

        if ($cart->isProductIdIs($whichProductSelectedId, $cartArray)) {
//            $productToReturnToWarehouse = $dataArray[$whichProductSelectedId];
//            echo $productToReturnToWarehouse->getName() . ' : ' . $productToReturnToWarehouse->getQuantity() . PHP_EOL;
            //paklausti kiek nori isimti
            (int)$quantityOfProductToRemove = readline("Enter the quantity of product you want to  remove : " . PHP_EOL);
            echo PHP_EOL;
            echo "Selected quantity: $quantityOfProductToRemove" . PHP_EOL;
            //isimti is krepselio
            $productToReturnToWarehouse = $dataArray[$whichProductSelectedId];
            if ($cartArray[$whichProductSelectedId] >= $quantityOfProductToRemove) {
                $cartArray[$whichProductSelectedId] -= $quantityOfProductToRemove;
                //prideti prie warehouso ta kieki
                $productToReturnToWarehouse->setQuantity($productToReturnToWarehouse->getQuantity() + $quantityOfProductToRemove);
                $totalBalanceAfterRemoved = $totalBalance - ($currency->convertCurrency($defaultCurrency, $dataArray[$key]->getPrice(), $dataArray[$key]->getCurrency()));
                echo "Total Balance: 
                " . $totalBalanceAfterRemoved;
            } else {
                echo "Pasirinkite mazesni kieki nei $cartArray[$whichProductSelectedId] " . PHP_EOL;
            }
        } else {
            echo "Tokio product Number nera";
        }

    } else {
        //jei ne
        // nenori isimti
        // parodyti total balance
        echo $totalBalance;
    }
}


//print_r($productSelected);
//print_r($cartArray);
//print_r($dataArray);
