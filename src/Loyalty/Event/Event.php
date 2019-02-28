<?php

namespace App\Loyalty\Event;

abstract class Event
{
    /**
     * @var \DateTimeImmutable
     */
    private $created;

    /**
     * @var int
     */
    private $version;

    /**
     * Event constructor.
     */
    public function __construct()
    {
        $this->created = new \DateTimeImmutable();
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreated(): \DateTimeImmutable
    {
        return $this->created;
    }

    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * @param int $version
     */
    public function setVersion(int $version): void
    {
        $this->version = $version;
    }
}