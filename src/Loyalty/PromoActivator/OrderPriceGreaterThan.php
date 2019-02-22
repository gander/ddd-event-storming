<?php

namespace App\Loyalty\PromoActivator;

use App\Loyalty\OrderDTO;
use App\Loyalty\PromoActivator;
use Money\Money;

class OrderPriceGreaterThan implements PromoActivator
{
    /**
     * @var Money
     */
    private $limit;

    /**
     * OrderPriceGreaterThan constructor.
     * @param Money $limit
     */
    public function __construct(Money $limit)
    {
        $this->limit = $limit;
    }

    public function isSatisfiedFor(OrderDTO $orderDTO): bool
    {
        return $orderDTO->getPrice()->greaterThan($this->limit);
    }
}