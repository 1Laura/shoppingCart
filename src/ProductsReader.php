<?php


namespace src;


use ReflectionClass;

class ProductsReader
{


    function csv_parse($filepath, $options = array())
    {
        if (!is_readable($filepath)) {
            return FALSE;
        }

        // Merge default options
        $options = array_merge(array(
            'eol' => "\n",
            'delimiter' => ';',
            'enclosure' => '"',
            'escape' => '\\',
            'to_object' => false,
        ), $options);

        // Read file, explode into lines
        $string = file_get_contents($filepath);
        $lines = explode($options['eol'], $string);

        // Read the first row, consider as field names
        $header = array_map('trim', explode($options['delimiter'], array_shift($lines)));

        // Build the associative array
        $csv = array();
        $productClass = new ReflectionClass(Product::class);
        foreach ($lines as $line) {
            // Skip if empty
            if (empty($line)) {
                continue;
            }

            // Explode the line
            $fields = str_getcsv($line, $options['delimiter'], $options['enclosure'], $options['escape']);
            // Initialize the line array/object


//            $temp = $options['to_object'] ? new stdClass : array();

//            foreach ($header as $index => $key) {
//                $options['to_object']
//                    ? $temp->{trim($key)} = trim($fields[$index])
//                    : $temp[trim($key)] = trim($fields[$index]);
//            }


            $productObj = new Product();
            foreach ($header as $index => $key) {
                if (!$productClass->hasProperty($key)) {
                    throw new Exception($key . ' is not a valid property');
                }
                if (!$productClass->hasMethod('set' . ucfirst($key))) {
                    throw new Exception($key . ' is missing a setter');
                }
                $setter = $productClass->getMethod('set' . ucfirst($key));
                $setter->invoke($productObj, $fields[$index]);
//                $setter->invoke($productObj);
//
            }
            $csv[] = $productObj;


//            $temp = $options['to_object'] ? new Product() : array();
//            foreach ($header as $index => $key) {
//                var_dump($index);
//                var_dump($key);
////                print_r('set' . trim($key) . '(' . trim($fields[$index]) . ');');
//                $temp->{'set' . trim($key) . '(' . trim($fields[$index]) . ');'};
//                //$options['to_object'] ? $temp->{trim($key)} = trim($fields[$index]) : $temp[trim($key)] = trim($fields[$index]);
//            }

//            $csv[] = $temp;
        }

        return $csv;
    }

    public function getProductName()
    {
        
    }



}