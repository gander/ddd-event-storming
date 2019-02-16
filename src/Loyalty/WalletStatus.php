<?php

namespace App\Loyalty;

use MyCLabs\Enum\Enum;

/**
 * @method static UNBLOCKED
 * @method static BLOCKED
 */
class WalletStatus extends Enum
{
    public const UNBLOCKED = 'unblocked';
    public const BLOCKED = 'blocked';
}
