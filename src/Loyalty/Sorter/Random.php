<?php

namespace App\Loyalty\Sorter;

use App\Loyalty\Sorter;

class Random implements Sorter
{
    public function sort(array $points): array
    {
        shuffle($points);

        return $points;
    }
}


