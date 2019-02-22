<?php

namespace App\Loyalty;

use App\Loyalty\Exception\InsufficientBalanceException;

class Wallet
{
    /**
     * @var Email
     */
    private $email;

    /**
     * @var Status
     */
    private $status;

    /**
     * @var Points[]
     */
    private $points = [];

    /**
     * @var Sorter
     */
    private $sorter;

    /**
     * Wallet constructor.
     * @param Email $email
     * @param Sorter $sorter
     */
    public function __construct(Email $email, Sorter $sorter)
    {
        $this->email = $email;
        $this->status = Status::UNBLOCKED();
        $this->sorter = $sorter;
    }

    public function addPoints(Points $points): void
    {
        if (!$this->canAddPoints()) {
            throw new \Exception(); // @todo Nowy exception, ale konkretny
        }

        $this->points[] = $points;
        $this->points = $this->sorter->sort($this->points);
    }

    public function withdrawPoints(Points $points): void
    {
        if (!$this->canWithdrawPoints($points)) {
            throw new InsufficientBalanceException(/* .. */);
            // throw new \Exception(); // TAK NIE!
        }

        // ..
        $this->points = [new StandardPoints($this->getBalance()->getAmount() - $points->getAmount())];
    }

    public function block(string $reason): void
    {
        // @todo Dodac zabezpieczenie

        $this->status = Status::BLOCKED();

        // ..
    }

    public function unblock(string $reason): void
    {
        // @todo Dodac zabezpieczenie

        $this->status = Status::UNBLOCKED();

        // ..
    }

    public function getBalance(): Points
    {
        $sum = 0;

        foreach ($this->points as $points) {
            $sum += $points->getAmount();
        }

        return new StandardPoints($sum);
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }
    
    /**
     * @param Points $points
     * @return bool
     */
    private function canWithdrawPoints(Points $points): bool
    {
        return $points->getAmount() <= $this->getBalance()->getAmount() && $this->status == Status::UNBLOCKED();
    }

    /**
     * @return bool
     */
    private function canAddPoints(): bool
    {
        return $this->status != Status::BLOCKED();
    }
}