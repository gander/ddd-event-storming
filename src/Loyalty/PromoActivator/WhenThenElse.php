<?php

namespace App\Loyalty\PromoActivator;

use App\Loyalty\OrderDTO;
use App\Loyalty\PromoActivator;

class WhenThenElse implements PromoActivator
{
    /** @var PromoActivator */
    private $when;
    /** @var PromoActivator */
    private $then;
    /** @var PromoActivator */
    private $else;


    public function isSatisfiedFor(OrderDTO $orderDTO): bool
    {

    }

}
