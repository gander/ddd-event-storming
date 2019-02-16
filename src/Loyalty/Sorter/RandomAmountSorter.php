<?php

namespace App\Loyalty\Sorter;

use App\Loyalty\Sorter;

class RandomAmountSorter implements Sorter
{
    public function sort(array $pointsCollection): array
    {
        shuffle($pointsCollection);
        return $pointsCollection;
    }

}
