<?php

namespace App\Loyalty;

class Email implements IEmail
{
    /**
     * @var string
     */
    private $address;

    /**
     * Email constructor.
     * @param string $address
     */
    public function __construct(string $address)
    {
        // @todo walidacja adresu

        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }
}