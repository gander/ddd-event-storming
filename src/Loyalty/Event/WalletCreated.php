<?php

namespace App\Loyalty\Event;

use App\Loyalty\Email;
use App\Loyalty\Event;

class WalletCreated extends Event
{
    /**
     * @var Email
     */
    private $email;

    /**
     * @param Email $email
     */
    public function __construct(Email $email)
    {
        parent::__construct();

        $this->email = $email;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }
}
