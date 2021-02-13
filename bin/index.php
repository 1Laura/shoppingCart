#!/usr/bin/env php
<?php

//require __DIR__ . '/../vendor/autoload.php';

use src\ProductsReader;
use src\Shop;

require 'vendor/autoload.php';

//$shop = new Shop;
//echo "Set currency \n";
//$shop->setCurrency();
//echo "Data from text file \n";
//$shop->getDataFromTextFile();
//echo "Display Data from text file \n";
//$shop->displayAllDataFromTextFile();

$product = new ProductsReader;
$product->csv_parse("bin/data.txt");
print_r($product->csv_parse("bin/data.txt"));