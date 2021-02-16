<?php


namespace app\src;


use ReflectionClass;

class ProductsReader
{

    function txt_parse($filepath, $options = array())
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
            $productObj = new Product();
            foreach ($header as $index => $key) {
                $productClass->hasProperty($key);
                $productClass->hasMethod('set' . ucfirst($key));

//                if (!$productClass->hasProperty($key)) {
//                    throw new Exception($key . ' is not a valid property');
//                }
//                if (!$productClass->hasMethod('set' . ucfirst($key))) {
//                    throw new Exception($key . ' is missing a setter');
//                }
                $setter = $productClass->getMethod('set' . ucfirst($key));
                $setter->invoke($productObj, $fields[$index]);
            }
            $csv[$productObj->getId()] = $productObj;
        }
        return $csv;
    }


}