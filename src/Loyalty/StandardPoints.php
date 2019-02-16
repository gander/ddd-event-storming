<?php


namespace App\Loyalty;


use Webmozart\Assert\Assert;

class StandardPoints implements Points
{
    /**
     * @var integer
     */
    private $amount;

    /**
     * @param int $amount
     */
    public function __construct(int $amount)
    {
        Assert::greaterThan($amount, 0);

        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    public function subPoints(int $amount): Points
    {
        return new self($this->amount - $amount);
    }


}
