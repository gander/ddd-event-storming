<?php

namespace App\Loyalty;

use MyCLabs\Enum\Enum;

/**
 * @method static UNBLOCKED()
 * @method static BLOCKED()
 */
class Status extends Enum
{
    private const BLOCKED = 0;
    private const UNBLOCKED = 1;
}