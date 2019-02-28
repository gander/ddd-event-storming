<?php

namespace App\Loyalty;

use App\Loyalty\Command\AddPoints;
use App\Loyalty\Command\UsePoints;
use App\Loyalty\Event\Event;
use App\Loyalty\Event\PointsUsed;
use App\Loyalty\Event\TransferInitiated;
use Prooph\ServiceBus\CommandBus;

class TransferProcess
{
    /**
     * @var CommandBus
     */
    private $commandBus;
    private $toEmail;
    private $points;

    /**
     * TransferProcess constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Event $event)
    {
        switch (get_class($event)) {
            case TransferInitiated::class:
                /** @var $event TransferInitiated */
                $this->commandBus->dispatch(new UsePoints($event->getFromEmail(), $event->getPoints()));
                $this->toEmail = $event->getToEmail();
                $this->points = $event->getPoints();
                break;
            case PointsUsed::class:
                /** @var $event PointsUsed */
                $this->commandBus->dispatch(new AddPoints($this->toEmail, $this->points));
                break;
        }
    }
}