<?php

namespace App\Loyalty;

interface Points
{
    /**
     * @return int
     */
    public function getAmount(): int;

    public function subPoints(int $amount): Points;

//    public function canTransfer(): bool;
}
