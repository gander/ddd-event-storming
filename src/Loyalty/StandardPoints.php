<?php

namespace App\Loyalty;

use Webmozart\Assert\Assert;

class StandardPoints implements Points
{
    /**
     * @var int
     */
    private $amount;

    /**
     * Points constructor.
     * @param int $amount
     */
    public function __construct(int $amount)
    {
        Assert::greaterThanEq($amount, 0);

        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }
}