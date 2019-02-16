<?php

namespace App\Loyalty;

interface Sorter
{
    public function sort(array $pointsCollection): array;
}
