<?php

namespace App\Loyalty\PromoActivator;

use App\Loyalty\OrderDTO;
use App\Loyalty\PromoActivator;

class OrX implements PromoActivator
{
    /**
     * @var PromoActivator[]
     */
    private $promoActivators;

    /**
     * @param PromoActivator[] $promoActivators
     */
    public function __construct(array $promoActivators)
    {
        $this->promoActivators = $promoActivators;
    }

    public function isSatisfiedFor(OrderDTO $orderDTO): bool
    {
        foreach ($this->promoActivators as $promoActivator) {
            if ($promoActivator->isSatisfiedFor($orderDTO)) {
                return true;
            };
        }

        return false;
    }
}
