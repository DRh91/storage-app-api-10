<?php

use Faker\Provider\Uuid;

;

//$categories = json_decode($categories, true);
//var_dump($categories);



while (strpos($categories, '_id_')) {
    $categories = preg_replace('_\_id\__', '$$' . randomNumber(), $categories, 1);
}
echo $categories;


function randomNumber($nbDigits = 6, $strict = false)
{
    $max = pow(10, $nbDigits) - 1;
    if ($max > mt_getrandmax()) {
        throw new \InvalidArgumentException('randomNumber() can only generate numbers up to mt_getrandmax()');
    }
    if ($strict) {
        return mt_rand(pow(10, $nbDigits - 1), $max);
    }

    return mt_rand(0, $max);
}
