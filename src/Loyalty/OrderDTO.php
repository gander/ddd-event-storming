<?php

namespace App\Loyalty;

use Money\Money;

class OrderDTO
{
    /**
     * @var Money
     */
    private  $price;
    /**
     * @var Email
     */
    private $customerEmail;

    /**
     * @param Money $price
     * @param Email $customerEmail
     */
    public function __construct(Money $price, Email $customerEmail)
    {
        $this->price = $price;
        $this->customerEmail = $customerEmail;
    }

    /**
     * @return Money
     */
    public function getPrice(): Money
    {
        return $this->price;
    }

    /**
     * @return Email
     */
    public function getCustomerEmail(): Email
    {
        return $this->customerEmail;
    }
}
