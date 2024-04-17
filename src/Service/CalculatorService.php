<?php

namespace App\Service;

class CalculatorService
{
    public function sum(int ...$args)
    {
        $total = 0;
        foreach ($args as $number) {
            $total += $number;
        }
        return $total;
    }
}