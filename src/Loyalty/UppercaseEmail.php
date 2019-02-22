<?php

namespace App\Loyalty;

class UppercaseEmail implements IEmail
{
    /**
     * @var IEmail
     */
    private $email;

    /**
     * UppercaseEmail constructor.
     * @param IEmail $email
     */
    public function __construct(IEmail $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return strtoupper($this->email->getAddress());
    }
}