<?php

namespace src;

class Shop
{

    public function __construct()
    {
        echo "Welcome to shop from construct \n";
    }

    public function setCurrency()
    {
//        $dataArray = [
//            'currency' => '',
//        ];
        echo "Type selected currency 'EUR' or 'USD' or 'GBP': ";
        $handle = fopen("php://stdin", "r");
        $currencyInput = fgets($handle);
        if ($currencyInput == 'eur') {
            $$currencyInput = 'eur';
        } elseif ($currencyInput == 'usd') {
            $$currencyInput = 'usd';
        } elseif ($currencyInput == 'gbp') {
            $$currencyInput = 'gbp';
        }
        $dataArray['currency'] = $currencyInput;
        readline_add_history($currencyInput);
//        print_r(readline_list_history());
//        print_r($dataArray['currency']);
        print_r($dataArray);


    }


    public function getDataFromTextFile()
    {
        // CSV failo turinio priskyrimas kintamajam
        $connR = fopen('../data.txt', 'r');
        $data = fgetcsv($connR);
        fclose($connR);
        echo $data;
    }


//    function pause()
//    {
//        $handle = fopen("php://stdin", "r");
//        do {
//            $line = fgets($handle);
//        } while ($line == '');
//        fclose($handle);
//        return $line;
//    }
}
