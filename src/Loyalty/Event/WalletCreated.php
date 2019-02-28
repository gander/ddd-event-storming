<?php

namespace App\Loyalty\Event;

use App\Loyalty\Email;
use App\Loyalty\Sorter;

class WalletCreated extends Event
{
    /**
     * @var Email
     */
    private $email;

    /**
     * @var Sorter
     */
    private $sorter;

    /**
     * WalletCreated constructor.
     * @param Email $email
     * @param Sorter $sorter
     */
    public function __construct(Email $email, Sorter $sorter)
    {
        parent::__construct();

        $this->email = $email;
        $this->sorter = $sorter;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return Sorter
     */
    public function getSorter(): Sorter
    {
        return $this->sorter;
    }
}