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
     * @var WalletStatus
     */
    private $status;

    /**
     * @var PointsCollection
     */
    private $points;

    public function __construct(Email $email, Sorter $sorter)
    {
        $this->email = $email;
        $this->status = WalletStatus::UNBLOCKED();
        $this->points = new PointsCollection([], $sorter);
    }

    public function addPoints(Points $points): void
    {
        if (!$this->isUnBlocked()) {
            throw new Exceptions\BlockedWalletException();
        }

        $this->points->addPoints($points);
    }

    public function withdrawPoints(Points $points): void
    {
        if (!$this->canWithdrawPoints($points)) {
            throw new InsufficientBalanceException();
        }

        $this->points->subPoints($points);
    }

    public function block(string $reason): void
    {
        $this->status = WalletStatus::BLOCKED();
    }

    public function unblock(string $reason): void
    {
        $this->status = WalletStatus::UNBLOCKED();
    }

    public function getStatus(): WalletStatus
    {
        return $this->status;
    }

    public function getBalance(): Points
    {
        $amount = 0;
        foreach ($this->points as $point) {
            $amount += $point->getAmount();
        }
        return new StandardPoints($amount);
    }

    /**
     * @param Points $points
     * @return bool
     */
    private function canWithdrawPoints(Points $points): bool
    {
        return $this->isUnBlocked() && ($this->getBalance()->getAmount() >= $points->getAmount());
    }

    /**
     * @return bool
     */
    public function isUnBlocked(): bool
    {
        return $this->status->equals(WalletStatus::UNBLOCKED());
    }
}
