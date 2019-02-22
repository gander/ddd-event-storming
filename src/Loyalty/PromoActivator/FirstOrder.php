<?php

namespace App\Loyalty\PromoActivator;

use App\Loyalty\OrderDTO;
use App\Loyalty\OrderHistoryProvider;
use App\Loyalty\PromoActivator;

class FirstOrder implements PromoActivator
{
    /**
     * @var OrderHistoryProvider
     */
    private $orderHistoryProvider;

    /**
     * @param OrderHistoryProvider $orderHistoryProvider
     */
    public function __construct(OrderHistoryProvider $orderHistoryProvider)
    {
        $this->orderHistoryProvider = $orderHistoryProvider;
    }

    public function isSatisfiedFor(OrderDTO $orderDTO): bool
    {
        return $this->orderHistoryProvider->getOrdersCount($orderDTO->getCustomerEmail()) === 0;
    }
}
