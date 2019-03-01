<?php

use App\Loyalty\Command\AddPoints;
use App\Loyalty\Command\CreateWallet;
use App\Loyalty\Command\TransferPoints;
use App\Loyalty\Command\UsePoints;
use App\Loyalty\Email;
use App\Loyalty\Event\PointsUsed;
use App\Loyalty\Event\TransferInitiated;
use App\Loyalty\LoyaltyService;
use App\Loyalty\Repository\EventWrapped;
use App\Loyalty\Repository\InMemoryWallets;
use App\Loyalty\SorterFactory;
use App\Loyalty\TransferProcess;
use Gaufrette\Adapter\Local;
use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\EventBus;
use Prooph\ServiceBus\Plugin\Router\CommandRouter;
use Prooph\ServiceBus\Plugin\Router\EventRouter;

require_once 'vendor/autoload.php';

$eventBus = new EventBus();
$eventRouter = new EventRouter();

$adapter = new Local('var/wallets/');
//$adapter = new Zip('var/wallets/wallets.zip');
//$wallets = new GaufretteFilesystemWallets(new Filesystem($adapter));
$wallets = new EventWrapped($eventBus, new InMemoryWallets());

$email = date('YmdHis') . '@example.org';
$email2 = date('YmdHis') . '@example-transferred.org';

$service = new LoyaltyService($wallets, new SorterFactory());

$commandBus = new CommandBus();
$commandRouter = new CommandRouter();

$commandRouter->attachToMessageBus($commandBus);
$commandRouter
    ->route(CreateWallet::class)
    ->to([$service, 'createWallet']);
$commandRouter
    ->route(AddPoints::class)
    ->to([$service, 'addPoints']);
$commandRouter
    ->route(UsePoints::class)
    ->to([$service, 'usePoints']);
$commandRouter
    ->route(TransferPoints::class)
    ->to([$service, 'transferPoints']);

$transferProcess = new TransferProcess($commandBus);

$eventRouter->attachToMessageBus($eventBus);
$eventRouter
    ->route(TransferInitiated::class)
    ->to($transferProcess);
$eventRouter
    ->route(PointsUsed::class)
    ->to($transferProcess);

$eventRouter->route(\App\Loyalty\Event\WalletCreated::class)->to(function () {
    var_dump('DZIALA');
});

$commandBus->dispatch(new CreateWallet($email));
$commandBus->dispatch(new CreateWallet($email2));
$commandBus->dispatch(new AddPoints($email, 10));
$commandBus->dispatch(new AddPoints($email, 20));
$commandBus->dispatch(new TransferPoints($email, $email2, 10));

var_dump(($wallets->get(new Email($email))->getBalance()));
var_dump(($wallets->get(new Email($email2))->getBalance()));

