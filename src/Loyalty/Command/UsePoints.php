<?php

namespace App\Loyalty\Command;

class UsePoints
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var int
     */
    private $points;

    /**
     * AddPoints constructor.
     * @param string $email
     * @param int $points
     */
    public function __construct(string $email, int $points)
    {
        $this->email = $email;
        $this->points = $points;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }
}