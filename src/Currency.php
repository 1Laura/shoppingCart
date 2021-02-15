<?php

namespace src;

class Currency
{
    private $currencyArr = [
        '1' => 'EUR',
        '2' => 'USD',
        '3' => 'GBP'
    ];


    public function __construct()
    {
        echo "Welcome to shop" . PHP_EOL;
    }

    public function currencyList()
    {
        foreach ($this->currencyArr as $index => $item) {
            echo $index . '. ' . $item . PHP_EOL;
        }
    }

    public function setCurrency($currencyAsked)
    {
        $defaultCurrency = '';
        if ($currencyAsked == array_search('EUR', $this->currencyArr)) {
            $defaultCurrency = $this->currencyArr['1'];
        } elseif ($currencyAsked == array_search('USD', $this->currencyArr)) {
            $defaultCurrency = $this->currencyArr['2'];
        } elseif ($currencyAsked == array_search('GBP', $this->currencyArr)) {
            $defaultCurrency = $this->currencyArr['3'];
        } else {
            echo "You need to choose a currency" . PHP_EOL;
//            $currencyAsked = readline("Type number which currency you want to set default: ");
//            $defaultCurrency = false;
            exit;
        }

        return $defaultCurrency;
    }


    public function convertCurrency($defaultCurrency, $productPriceFromFile, $productCurrencyFromFile)
    {
        $convertedPrice = '';
        if ($defaultCurrency === $this->currencyArr['1']) {//eur
            if ($productCurrencyFromFile === $this->currencyArr['2']) {//usd
                $convertedPrice = round($productPriceFromFile / 1.14, 2);
            } elseif ($productCurrencyFromFile === $this->currencyArr['3']) {//gbp
                $convertedPrice = round($productPriceFromFile / 0.88, 2);
            } else {
                $convertedPrice = $productPriceFromFile;
            }
            // '2' => 'USD',
        } elseif ($defaultCurrency === $this->currencyArr['2']) {//usd
            if ($productCurrencyFromFile == $this->currencyArr['1']) {//eur
                $convertedPrice = round($productPriceFromFile * 1.14, 2);
            } elseif ($productCurrencyFromFile === $this->currencyArr['3']) {//gbp
                $convertedPrice = round($productPriceFromFile / (0.88 * 1.14), 2);
            } else {
                $convertedPrice = $productPriceFromFile;
            }
            //'3' => 'GBP'
        } elseif ($defaultCurrency === $this->currencyArr['3']) {//gbp
            if ($productCurrencyFromFile === $this->currencyArr['1']) {//eur
                $convertedPrice = round($productPriceFromFile * 0.88, 2);
            } elseif ($productCurrencyFromFile === $this->currencyArr['2']) {//usd
                $convertedPrice = round($productPriceFromFile * (1.14 * 0.88), 2);
            } else {
                $convertedPrice = $productPriceFromFile;
            }
        }
        return $convertedPrice;
    }


}
