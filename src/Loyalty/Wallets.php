<?php

namespace App\Loyalty;

interface Wallets
{
    public function save(Wallet $wallet): void;

    public function get(Email $email): Wallet;
}
