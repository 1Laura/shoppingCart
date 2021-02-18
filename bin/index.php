#!/usr/bin/env php
<?php
require 'vendor/autoload.php';

use app\src\CartService;
use app\src\ProductsReader;
use app\src\Currency;

$currency = new Currency;
$cart = new CartService();
$products = new ProductsReader();

$defaultCurrency = $cart->applyDefaultCurrency($currency);
$productsWarehouse = $products->txt_parse("bin/data.txt");

$cartArray = [];
$chooseProduct = readline("If you want to choose a product - Enter [yes], otherwise enter [no] : ");
echo PHP_EOL;
if ($chooseProduct === 'yes') {
    while ($chooseProduct === 'yes') {

        // a list of products is displayed
        print_r("ID " . "Product Name" . ' ' . "Price" . ' ' . "Currency" . 'Quantity' . PHP_EOL);
        foreach ($productsWarehouse as $product) {
            $price = $currency->convertCurrency($defaultCurrency, $product->getPrice(), $product->getCurrency());
            print_r($product->getId() . '. ' . $product->getName() . ', ' . $price . ' ' . $defaultCurrency . ' :  ' . $product->getQuantity() . PHP_EOL);
        }
        echo PHP_EOL;

        //  user selected product
        $inputProductNumber = readline("Type number which product you want add to cart: " . PHP_EOL);
        $selectedProductNumber = $cart->getSelectedProductId($inputProductNumber, $productsWarehouse);
        $productSelected = $productsWarehouse[$selectedProductNumber];
        print_r($productSelected->getName() . " : " . $productSelected->getQuantity() . PHP_EOL);

        // the quantity of the product selected by the user
        (int)$productQuantityAsked = readline("Enter the product quantity: " . PHP_EOL);
        if ($cart->isQuantityInStock($productSelected, $productQuantityAsked)) {
            // product remove from warehouse
            $productSelected->setQuantity($productSelected->getQuantity() - $productQuantityAsked);
            echo PHP_EOL;
            // echo "Selected quantity: $productQuantityAsked" . PHP_EOL;

            //add to cart
            if (array_key_exists($selectedProductNumber, $cartArray)) {
                $cartArray[$selectedProductNumber] += $productQuantityAsked;
            } else {
                $cartArray[$selectedProductNumber] = $productQuantityAsked;
            }
        }
        $chooseProduct = readline("If you want to choose a product - Enter [yes], otherwise enter [no] :  " . PHP_EOL);
        echo PHP_EOL;
    }
} else {
    echo PHP_EOL;
    echo "Thank you!";
}
if ($chooseProduct === 'no') {
    if (empty($cartArray)) {
        echo PHP_EOL;
        echo "We are waiting for your return !";
        exit();
    }
    //if user want to remove product
    $totalBalance = 0.00;
    echo "Your carts: " . PHP_EOL;
    foreach ($cartArray as $key => $cartProduct) {
        $cartProductQuantity = $cartArray[$key];
        $cartProductPrice = $currency->convertCurrency($defaultCurrency, $productsWarehouse[$key]->getPrice(), $productsWarehouse[$key]->getCurrency());
        print_r($productsWarehouse[$key]->getId() . ' . ' . $productsWarehouse[$key]->getName() . ' , ' . $cartProductQuantity . ' , ' . $cartProductPrice . PHP_EOL);
        $totalBalance += $cartProductPrice * $cartProductQuantity;
    }
    print_r("Total balance:  " . $totalBalance . PHP_EOL);

    //remove from cart
    echo PHP_EOL;
    $wantToRemoveProduct = readline("If you want to remove a product - Enter [yes], otherwise enter [no] : " . PHP_EOL);
    echo PHP_EOL;
    // if  user want to remove a product
    if ($wantToRemoveProduct === 'yes') {
        while ($wantToRemoveProduct === 'yes') {

            // cartArray list
            foreach ($cartArray as $key => $cartProduct) {
                $cartProductName = $productsWarehouse[$key]->getName();
                $cartProductQuantity = $cartArray[$key];
                $cartProductPrice = $currency->convertCurrency($defaultCurrency, $productsWarehouse[$key]->getPrice(), $productsWarehouse[$key]->getCurrency());
                echo $key . ' . ' . $cartProductName . ' : ' . $cartProductPrice . ' * ' . $cartProductQuantity . ' = ' . $cartProductPrice * $cartProductQuantity . PHP_EOL;
            }
            //what product want to remove
            echo PHP_EOL;
            $whichProductSelectedId = readline("Type number which product you want to remove from cart  : " . PHP_EOL);
            echo PHP_EOL;

            if ($cart->isProductIdIs($whichProductSelectedId, $cartArray)) {
                //quantity of product to remove
                (int)$quantityOfProductToRemove = readline("Enter the quantity of product you want to  remove : " . PHP_EOL);
                echo PHP_EOL;

                //remove from cart
                $productToReturnToWarehouse = $productsWarehouse[$whichProductSelectedId];

                if ($cartArray[$whichProductSelectedId] >= $quantityOfProductToRemove) {
                    echo "Selected quantity: $quantityOfProductToRemove" . PHP_EOL;
                    $cartArray[$whichProductSelectedId] -= $quantityOfProductToRemove;

                    //return to warehouse
                    $productToReturnToWarehouse->setQuantity($productToReturnToWarehouse->getQuantity() + $quantityOfProductToRemove);
                    $totalBalanceAfterRemoved = 0.00;

                } else {
                    echo "Please select less than $cartArray[$whichProductSelectedId] " . PHP_EOL;
                }
            } else {
                echo "There is no such product in your cart";
            }
            echo PHP_EOL;
            $wantToRemoveProduct = readline("If you want to remove a product - Enter [yes], otherwise enter [no] : " . PHP_EOL);
            echo PHP_EOL;
        }
    }
    if ($wantToRemoveProduct === 'no') {
        //cart array list
        echo "Your carts: " . PHP_EOL;
        $finalTotalBalance = 0.00;
        foreach ($cartArray as $key => $cartProduct) {
            $cartProductName = $productsWarehouse[$key]->getName();
            $cartProductQuantity = $cartArray[$key];
            $cartProductPrice = $currency->convertCurrency($defaultCurrency, $productsWarehouse[$key]->getPrice(), $productsWarehouse[$key]->getCurrency());
            $finalTotalBalance += $cartProductPrice * $cartProductQuantity;
            echo $key . ' . ' . $cartProductName . ' : ' . $cartProductPrice . ' * ' . $cartProductQuantity . ' = ' . $cartProductPrice * $cartProductQuantity . PHP_EOL;
        }
        // //total balance
        echo "Total Balance: " . $finalTotalBalance . PHP_EOL;
        echo "Thank you!" . PHP_EOL;;
        echo PHP_EOL;

        echo "Warehouse: " . PHP_EOL;
        foreach ($productsWarehouse as $product) {
            $price = $currency->convertCurrency($defaultCurrency, $product->getPrice(), $product->getCurrency());
            print_r($product->getId() . '. ' . $product->getName() . ', ' . $price . ' ' . $defaultCurrency . ' :  ' . $product->getQuantity() . PHP_EOL);
        }
    }
}