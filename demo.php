<?php
require_once __DIR__ . '/vendor/autoload.php';

$emailStr = 'some@one';

$adapter = new \Gaufrette\Adapter\SafeLocal('var/wallets');
$wallets = (new \App\Loyalty\Repository\GaufretteWallets(new \Gaufrette\Filesystem($adapter)));
$service = new \App\Loyalty\WalletService($wallets);

$service->create($emailStr);
$service->addPoints($emailStr, 100);
$service->withdrawPoints($emailStr, 50);
