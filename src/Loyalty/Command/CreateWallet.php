<?php

namespace App\Loyalty\Command;

use App\Loyalty\Email;

class CreateWallet
{
    /**
     * @var string
     */
    private $email;

    /**
     * CreateWallet constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): Email
    {
        return new Email($this->email);
    }
}