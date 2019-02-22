<?php

namespace App\Loyalty\Event;

use App\Loyalty\Email;
use App\Loyalty\Event;
use App\Loyalty\Points;

class PointsAdded extends Event
{
    /**
     * @var Email
     */
    private $email;

    /**
     * @var Points
     */
    private $points;

    /**
     * @param Email $email
     * @param Points $points
     */
    public function __construct(Email $email, Points $points)
    {
        parent::__construct();

        $this->email = $email;
        $this->points = $points;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return Points
     */
    public function getPoints(): Points
    {
        return $this->points;
    }
}
