<?php

namespace App\Loyalty;

use App\Loyalty\Sorter\RandomAmountSorter;

class LoyaltyService
{
    /**
     * @var Wallets
     */
    private $wallets;

    /**
     * @param Wallets $wallets
     */
    public function __construct(Wallets $wallets)
    {
        $this->wallets = $wallets;
    }

    /**
     * @param string $email
     */
    public function create(string $email)
    {
        $email = new Email($email);
        $wallet = new Wallet($email, new RandomAmountSorter());

        $this->wallets->save($wallet);
    }

    /**
     * @param string $email
     * @param int $amount
     * @throws Exception\BlockedWalletException
     */
    public function addPoints(string $email, int $amount)
    {
        $wallet = $this->wallets->get(new Email($email));

        $wallet->addPoints(new StandardPoints($amount));

        $this->wallets->save($wallet);
    }

    /**
     * @param string $email
     * @param int $amount
     * @throws Exception\InsufficientBalanceException
     * @throws Exception\BlockedWalletException
     */
    public function withdrawPoints(string $email, int $amount)
    {
        $wallet = $this->wallets->get(new Email($email));

        $wallet->withdrawPoints(new StandardPoints($amount));

        $this->wallets->save($wallet);
    }
}
