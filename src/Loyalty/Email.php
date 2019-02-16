<?php


namespace App\Loyalty;


class Email
{
    /**
     * @var string
     */
    private $address;

    /**
     * @param string $address
     */
    public function __construct(string $address)
    {
        // @todo walidacja
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
