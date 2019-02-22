<?php

namespace App\Loyalty\PromoActivator;

use App\Loyalty\OrderDTO;
use App\Loyalty\PromoActivator;

class NotX implements PromoActivator
{
    /**
     * @var PromoActivator
     */
    private $promoActivator;

    /**
     * AndX constructor.
     * @param PromoActivator $promoActivator
     */
    public function __construct(PromoActivator $promoActivator)
    {
        $this->promoActivator = $promoActivator;
    }

    public function isSatisfiedFor(OrderDTO $orderDTO): bool
    {
        return !$this->promoActivator->isSatisfiedFor($orderDTO);
    }
}