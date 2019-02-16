<?php

namespace App\Loyalty\Sorter;

use App\Loyalty\Points;
use App\Loyalty\Sorter;

class DescendingAmountSorter implements Sorter
{
    public function sort(array $pointsCollection): array
    {
        uasort($pointsCollection, [$this, 'doSort']);
        return $pointsCollection;
    }

    private function doSort(Points $a, Points $b)
    {
        return $b->getAmount() <=> $a->getAmount();
    }

}
