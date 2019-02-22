<?php

namespace App\Loyalty;

class AnonymizedEmail implements IEmail
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
        $parts = explode('@', $this->email->getAddress());

        return $parts[0][0] . '...@' . $parts[1];
    }
}