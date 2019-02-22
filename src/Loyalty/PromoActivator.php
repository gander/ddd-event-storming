<?php


namespace App\Loyalty;


interface PromoActivator
{
    public function isSatisfiedFor(OrderDTO $orderDTO): bool;
}
