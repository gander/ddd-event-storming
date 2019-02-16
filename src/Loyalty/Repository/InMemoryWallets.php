<?php


namespace App\Loyalty\Repository;


use App\Loyalty\Email;
use App\Loyalty\Wallet;
use App\Loyalty\Wallets;
use Webmozart\Assert\Assert;

class InMemoryWallets implements Wallets
{
    private $wallets;

    public function save(Wallet $wallet): void
    {
        $this->wallets[$wallet->getEmail()->getAddress()] = $wallet;
    }

    public function get(Email $email): Wallet
    {
        Assert::keyExists($this->wallets, $email->getAddress());

        return $this->wallets[$email->getAddress()];
    }
}
