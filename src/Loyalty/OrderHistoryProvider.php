<?php


namespace App\Loyalty;


interface OrderHistoryProvider
{
    public function getOrdersCount(Email $email): int;
}
