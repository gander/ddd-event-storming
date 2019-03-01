<?php

namespace App\Loyalty;

use App\Loyalty\Event\Event;
use App\Loyalty\Event\PointsAdded;
use App\Loyalty\Event\PointsUsed;
use App\Loyalty\Event\TransferInitiated;
use App\Loyalty\Event\WalletCreated;
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

    private $events = [];

    /**
     * @var int
     */
    private $version = 0;

    /**
     * @var array
     */
    private $transfers = [];

    private function __construct()
    {
    }

    public static function fromEvents(array $events): Wallet
    {
        $object = new self();

        foreach ($events as $event) {
            $object->handle($event);
            $object->version = $event->getVersion();
        }

        return $object;
    }

    public static function create(Email $email, Sorter $sorter)
    {
        $wallet = new self();

        $wallet->recordThat(new WalletCreated($email, $sorter));

        return $wallet;
    }

    private function recordThat(Event $event): void
    {
        $event->setVersion(++$this->version);

        $this->events[] = $event;

        $this->handle($event);
    }

    private function handle(Event $event): void
    {
        switch (get_class($event)) {
            case WalletCreated::class:
                /* @var $event WalletCreated */
                $this->email = $event->getEmail();
                $this->sorter = $event->getSorter();
                $this->status = Status::UNBLOCKED();
                break;
            case PointsAdded::class:
                /* @var $event PointsAdded */
                $this->points[] = $event->getPoints();
                $this->points = $this->sorter->sort($this->points);
                break;
            case PointsUsed::class:
                /* @var $event PointsUsed */
                $this->points = [new StandardPoints($this->getBalance()->getAmount() - $event->getPoints()->getAmount())];;
                break;
            case TransferInitiated::class:
                $this->transfers[] = new Transfer(); // @todo ...
                break;
        }
    }

    public function addPoints(Points $points): void
    {
        if (!$this->canAddPoints()) {
            throw new \Exception(); // @todo Nowy exception, ale konkretny
        }

        $this->recordThat(new PointsAdded($this->email, $points));
    }

    public function withdrawPoints(Points $points): void
    {
        if (!$this->canWithdrawPoints($points)) {
            throw new InsufficientBalanceException(/* .. */);
            // throw new \Exception(); // TAK NIE!
        }

        $this->recordThat(new PointsUsed($this->email, $points));
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

    public function extractEvents(): array
    {
        $events = $this->events;

        $this->events = [];

        return $events;
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

    public function initiateTransfer(Email $email, int $points)
    {
        if (!$this->canWithdrawPoints(new StandardPoints($points))) {
            throw new \InvalidArgumentException(); // @todo :)
        }

        $this->recordThat(new TransferInitiated($this->getEmail()->getAddress(), $email->getAddress(), $points));
    }
}
