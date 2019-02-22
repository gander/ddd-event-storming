<?php

namespace App\Loyalty;

use App\Loyalty\Sorter\DescendingAmountSorter;

class SorterFactory
{
    public function buildFor(Email $email): Sorter
    {
        return new DescendingAmountSorter();
    }
}