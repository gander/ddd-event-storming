<?php

namespace App\Loyalty\Repository;

use App\Loyalty\Email;
use App\Loyalty\Wallet;
use App\Loyalty\Wallets;

class InMemoryWallets implements Wallets
{
    /**
     * @var Wallets[]
     */
    private $wallets = [];

    public function save(Wallet $wallet): void
    {
        $this->wallets[$wallet->getEmail()->getAddress()] = $wallet;
    }

    public function get(Email $email): Wallet
    {
        // @todo Check!

        return $this->wallets[$email->getAddress()];
    }
}