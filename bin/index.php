#!/usr/bin/env php
<?php

//require __DIR__ . '/../vendor/autoload.php';

use src\Shop;

require 'vendor/autoload.php';

$shop = new Shop;
echo "Set currency \n";
$shop->setCurrency();

