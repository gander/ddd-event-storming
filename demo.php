<?php

use App\Loyalty\AnonymizedEmail;
use App\Loyalty\Command\CreateWallet;
use App\Loyalty\Email;
use App\Loyalty\LoyaltyService;
use App\Loyalty\OrderDTO;
use App\Loyalty\Repository\GaufretteFilesystemWallets;
use App\Loyalty\Sorter\Random;
use App\Loyalty\SorterFactory;
use App\Loyalty\StandardPoints;
use App\Loyalty\UppercaseEmail;
use App\Loyalty\Wallet;
use Gaufrette\Adapter\Local;
use Gaufrette\Adapter\Zip;
use Gaufrette\Filesystem;
use Money\Money;
use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\Plugin\Router\CommandRouter;

require_once 'vendor/autoload.php';


//$email = new Email('example@example.org');
//$upper = new AnonymizedEmail(new UppercaseEmail($email));
//
//echo $upper->getAddress() . PHP_EOL;
//exit;

$adapter = new Local('var/wallets/');
//$adapter = new Zip('var/wallets/wallets.zip');
$wallets = new GaufretteFilesystemWallets(new Filesystem($adapter));
$email = date('YmdHis').'@example.org';

$service = new LoyaltyService($wallets, new SorterFactory());

$commandBus = new CommandBus();
$commandRouter = new CommandRouter();

$commandRouter->attachToMessageBus($commandBus);
$commandRouter
    ->route(CreateWallet::class)
    ->to([$service, 'createWallet']);

$commandBus->dispatch(new CreateWallet($email));

//$service->addPointsForOrder(new OrderDTO(Money::PLN(101), new Email($email)));
//$service->addPointsForOrder(new OrderDTO(Money::PLN(201), new Email($email)));

var_dump(($wallets->get(new Email($email))->extractEvents()));

//$promoActivator = new AndX([
//    new \App\Loyalty\PromoActivator\OrderPriceGreaterThan(Money::PLN(5000)),
//    new FirstOrder(...),
//    new NotX(
//        new CustomerEmailFromDomain('gmail.com')
//    ),
//]);
