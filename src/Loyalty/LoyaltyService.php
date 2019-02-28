<?php

namespace App\Loyalty;

use App\Loyalty\Command\CreateWallet;
use App\Loyalty\PointsCalculation\Fixed;
use App\Loyalty\PointsCalculation\Ratio;
use App\Loyalty\PromoActivator\OrderPriceGreaterThan;
use App\Loyalty\Sorter\DescendingAmountSorter;
use App\Loyalty\Sorter\Random;
use Money\Money;

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

    public function addPoints(string $email, int $points)
    {
        $wallet = $this->wallets->get(new Email($email));

        $wallet->addPoints(new StandardPoints($points));

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