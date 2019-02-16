<?php

use App\Loyalty\WalletStatus;

require_once __DIR__ . '/vendor/autoload.php';


$wallet = new \App\Loyalty\Wallet(new \App\Loyalty\Email('some@one'), new \App\Loyalty\Sorter\DescendingAmountSorter());

$wallet->addPoints(new \App\Loyalty\StandardPoints(10));
$wallet->addPoints(new \App\Loyalty\StandardPoints(8));
$wallet->addPoints(new \App\Loyalty\StandardPoints(5));
$wallet->addPoints(new \App\Loyalty\StandardPoints(2));
$wallet->addPoints(new \App\Loyalty\ExpirablePoints(1, new \DateTimeImmutable()));
$wallet->addPoints(new \App\Loyalty\StandardPoints(20));
$wallet->addPoints(new \App\Loyalty\ExpirablePoints(1, (new \DateTimeImmutable())->modify('+1 hour')));


$wallet->withdrawPoints(new \App\Loyalty\StandardPoints(1));


$adapter = new \Gaufrette\Adapter\Zip('var/wallets/wallet.zip');



(new \App\Loyalty\Repository\GaufretteWallets(new \Gaufrette\Filesystem($adapter)))->save($wallet);



