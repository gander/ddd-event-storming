<?php

namespace App\Loyalty\Repository;

use App\Loyalty\Email;
use App\Loyalty\Wallet;
use App\Loyalty\Wallets;
use Prooph\ServiceBus\EventBus;

class EventWrapped implements Wallets
{
    /**
     * @var EventBus
     */
    private $eventBus;
    /**
     * @var Wallets
     */
    private $repo;

    /**
     * EventWrapped constructor.
     * @param EventBus $eventBus
     * @param Wallets $repo
     */
    public function __construct(EventBus $eventBus, Wallets $repo)
    {
        $this->eventBus = $eventBus;
        $this->repo = $repo;
    }

    public function save(Wallet $wallet): void
    {
        // UPROSZCZENIE, BO NIE MAMY BAZY...
        $eventsToPublish = $wallet->extractEvents();

        $this->repo->save($wallet);

        foreach($eventsToPublish as $eventToPublish) {
            $this->eventBus->dispatch($eventToPublish);
        }
    }

    public function get(Email $email): Wallet
    {
        return $this->repo->get($email);
    }
}