<?php

namespace src;

class Currency
{
    private $defaultCurrency = '';
    private $currencyArr = [
        '1' => 'EUR',
        '2' => 'USD',
        '3' => 'GBP'
    ];


    public function __construct()
    {
        echo "Welcome to shop from construct" . PHP_EOL;
    }

    public function setCurrency()
    {
//        echo "Type number wich currency you whant to set default: " . PHP_EOL;
        foreach ($this->currencyArr as $index => $item) {
            echo $index . '. ' . $item . PHP_EOL;
        }

        $inputCurrency = readline("Type number witch currency you want to set default: " );
//        print_r($inputCurrency . PHP_EOL);
        if ($inputCurrency == '1') {
            $defaultCurrency = $this->currencyArr['1'];
        } elseif ($inputCurrency == '2') {
            $defaultCurrency = $this->currencyArr['2'];
        } elseif ($inputCurrency == '3') {
            $defaultCurrency = $this->currencyArr['3'];
        } else {
            echo "You need to choose a currency" . PHP_EOL;
            $inputCurrency = readline("Type number witch currency you want to set default: " );
        }
//        print_r(array_key_exists($inputCurrency, $this->currencyArr) ? ' toks key yra' : 'tokio key nera') . PHP_EOL;

//        return $inputCurrency . ' it is ' . $defaultCurrency;
        return $defaultCurrency;
    }


//    public function convertCurrency($defaultCurrency, $dataArray)
//    {
//        $newDataArr = [];
//        // if '1' => 'EUR',
//        if (($defaultCurrency === $this->currencyArr['1'])) {
//            print_r('paspaude eur');
//            foreach ($dataArray as $key => $product) {
//                foreach ($product as $index => $productInfo) {
//                    if ($productInfo['currency'] === $this->currencyArr['2']) {
//                        $productInfo['price'] /= 1.14;
//                    } elseif ($productInfo['currency'] === $this->currencyArr['3']) {
//                        $productInfo['price'] /= 0.88;
//                    }
//                }
//            }
//            // '2' => 'USD',
//        } elseif (($defaultCurrency === $this->currencyArr['2'])) {
//            foreach ($dataArray as $key => $product) {
//                foreach ($product as $index => $productInfo) {
//                    if ($productInfo['currency'] === $this->currencyArr['1']) {
//                        $productInfo['price'] *= 1.14;
//                    } elseif ($productInfo['currency'] === $this->currencyArr['3']) {
//                        $productInfo['price'] /= (0.88 * 1.14);
//                    }
//                }
//            }
//        } //'3' => 'GBP'
//        elseif (($defaultCurrency === $this->currencyArr['3'])) {
//            foreach ($dataArray as $key => $product) {
//                foreach ($product as $index => $productInfo) {
//                    if ($productInfo['currency'] === $this->currencyArr['1']) {
//                        $productInfo['price'] *= 0.88;
//                    } elseif ($productInfo['currency'] === $this->currencyArr['2']) {
//                        $productInfo['price'] *= (1.14 * 0.88);
//                    }
//                }
//            }
//        }
//        return $dataArray;
//    }


//    public function getDataFromTextFile()
//    {
//        if (($connR = fopen('bin/data.txt', 'r')) !== false) {
//            while ($txtOneRow = fgetcsv($connR, 100, ';')) {
//                $arrayFromTextFile[] = $txtOneRow;
//            }
//            fclose($connR);
//        }
////        return $arrayFromTextFile;
//        print_r($arrayFromTextFile);
//    }

//    public function displayAllDataFromTextFile()
//    {
//        $file = file_get_contents("bin/data.txt", "r");
//        print_r($file);
//    }


}
