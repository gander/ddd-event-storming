<?php

namespace App\Loyalty\PromoActivator;

use App\Loyalty\OrderDTO;
use App\Loyalty\PromoActivator;

class EmailDomain implements PromoActivator
{
    /**
     * @var string
     */
    private $domain;

    /**
     * @param string $domain
     */
    public function __construct(string $domain)
    {
        $this->domain = $domain;
    }

    public function isSatisfiedFor(OrderDTO $orderDTO): bool
    {
        return parse_url($orderDTO->getCustomerEmail()->getAddress(), PHP_URL_HOST) === $this->domain;
    }
}
