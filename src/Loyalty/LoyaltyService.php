<?php

namespace App\Loyalty;

use App\Loyalty\Command\AddPoints;
use App\Loyalty\Command\CreateWallet;
use App\Loyalty\Command\TransferPoints;
use App\Loyalty\Command\UsePoints;
use App\Loyalty\Sorter\Random;

class LoyaltyService
{
    /**
     * @var Wallets
     */
    private $wallets;

    /**
     * @var SorterFactory
     */
    private $sorterFactory;

    /**
     * LoyaltyService constructor.
     * @param Wallets $wallets
     * @param SorterFactory $sorterFactory
     */
    public function __construct(Wallets $wallets, SorterFactory $sorterFactory)
    {
        $this->wallets = $wallets;
        $this->sorterFactory = $sorterFactory;
    }

    // createWallet

    public function createWallet(CreateWallet $command)
    {
        // @todo Obsluga bledow!
        $wallet = Wallet::create($command->getEmail(), new Random());

        $this->wallets->save($wallet);
    }

    public function addPoints(AddPoints $command)
    {
        $wallet = $this->wallets->get(new Email($command->getEmail()));

        $wallet->addPoints(new StandardPoints($command->getPoints()));

        $this->wallets->save($wallet);
    }

    public function usePoints(UsePoints $command)
    {
        $wallet = $this->wallets->get(new Email($command->getEmail()));

        $wallet->withdrawPoints(new StandardPoints($command->getPoints()));

        $this->wallets->save($wallet);
    }

    public function transferPoints(TransferPoints $command)
    {
        $wallet = $this->wallets->get(new Email($command->getFromEmail()));

        $wallet->initiateTransfer(new Email($command->getToEmail()), $command->getPoints());

        $this->wallets->save($wallet);
    }

    /**
     * UPROSZCZENIE!
     *
     * @param OrderDTO $orderDTO
     */
    public function addPointsForOrder(OrderDTO $orderDTO)
    {
        $promotions = (new PromotionFactory())->buildForCustomer($orderDTO->getCustomerEmail());
        $promotionsPoints = [];

        /**
         * @var $promotion PointsPromo
         */
        foreach ($promotions as $promotion) {
            $promotionsPoints[] = $promotion->calculatePoints($orderDTO);
        }

        $promotionsPoints = $this->sorterFactory->buildFor($orderDTO->getCustomerEmail())->sort($promotionsPoints);

        if (count($promotionsPoints)) {
            $pointsToAdd = $promotionsPoints[0];

            if ($pointsToAdd->getAmount() > 0) {
                $this->addPoints($orderDTO->getCustomerEmail()->getAddress(), $promotionsPoints[0]->getAmount());
            }
        }
    }

    // usePoints

    public function block(string $email, string $reason)
    {
        $wallet = $this->wallets->get(new Email($email));

        $wallet->block($reason);

        $this->wallets->save($wallet);
    }

    public function unblock(string $email, string $reason)
    {
        $wallet = $this->wallets->get(new Email($email));

        $wallet->unblock($reason);

        $this->wallets->save($wallet);
    }
}
