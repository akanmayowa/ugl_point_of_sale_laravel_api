<?php

namespace App\Helpers;

class GenerateRandomNumber
{
        public function uniqueRandomNumber($serialString, $numDigits): string
        {
            $numbers = range(0, 9);
            shuffle($numbers);
            $randNumber = '';

            for ($i = 0; $i < $numDigits; $i++) {
                $randNumber .= $numbers[$i];
            }
            return $serialString.$randNumber;
        }
}


