<?php

namespace App\Loyalty;

class ExpirablePoints implements Points
{
    /**
     * @var int
     */
    private $amount;

    /**
     * @var \DateTimeImmutable
     */
    public $expirationDate;

    /**
     * ExpirablePoints constructor.
     * @param int $amount
     * @param \DateTimeImmutable $expirationDate
     */
    public function __construct(int $amount, \DateTimeImmutable $expirationDate)
    {
        $this->amount = $amount;
        $this->expirationDate = $expirationDate;
    }

    public function getAmount(): int
    {
        return new \DateTimeImmutable() > $this->expirationDate ? 0 : $this->amount;
    }
}