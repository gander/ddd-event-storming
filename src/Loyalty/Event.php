<?php


namespace App\Loyalty;


class Event
{
    /** @var \DateTimeImmutable */
    private $createdAt;

    /**
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
