<?php

namespace App\Loyalty\Sorter;

use App\Loyalty\Points;
use App\Loyalty\Sorter;

class DescendingAmountSorter implements Sorter {

    public function sort(array $points): array {
        usort($points, function (Points $firstPoint, Points $secondPoint) {

            if ($firstPoint->getAmount() === $secondPoint->getAmount()) {
                return 0;
            }

            return $firstPoint->getAmount() < $secondPoint->getAmount() ? 1 : -1;
        });

        return $points;
    }
}