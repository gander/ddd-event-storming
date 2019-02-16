<?php

namespace App\Loyalty;

use Webmozart\Assert\Assert;

class ExpirablePoints implements Points
{
    /**
     * @var integer
     */
    private $amount;

    /**
     * @var \DateTimeImmutable
     */
    private $expirationDate;

    /**
     * @param int $amount
     * @param \DateTimeImmutable $expiration
     */
    public function __construct(int $amount, \DateTimeImmutable $expiration)
    {
        Assert::greaterThan($amount, 0);

        $this->amount = $amount;
        $this->expirationDate = $expiration;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getAmount(): int
    {
        return $this->isExpired() ? 0 : $this->amount;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    private function isExpired(): bool
    {
        return new \DateTimeImmutable() > $this->expirationDate;
    }

    /**
     * @param int $amount
     * @return Points
     * @throws \Exception
     */
    public function subPoints(int $amount): Points
    {
        return new static($this->getAmount() - $amount, $this->expirationDate);
    }

}
