<?php

namespace App\Loyalty\Event;

class TransferInitiated extends Event
{
    /**
     * @var string
     */
    private $fromEmail;

    /**
     * @var
     */
    private $toEmail;

    /**
     * @var int
     */
    private $points;

    /**
     * TransferPoints constructor.
     * @param string $fromEmail
     * @param $toEmail
     * @param int $points
     */
    public function __construct(string $fromEmail, $toEmail, int $points)
    {
        parent::__construct();

        $this->fromEmail = $fromEmail;
        $this->toEmail = $toEmail;
        $this->points = $points;
    }

    /**
     * @return string
     */
    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    /**
     * @return mixed
     */
    public function getToEmail()
    {
        return $this->toEmail;
    }

    /**
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }
}