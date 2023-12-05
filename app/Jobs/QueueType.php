<?php

namespace App\Jobs;

use BenSampo\Enum\Enum;

/**
 * @method static static urgent()
 * @method static static high()
 * @method static static default()
 * @method static static low()
 * @method static static long()
 */
final class QueueType extends Enum
{
    public const urgent = "urgent";
    public const high = "high";
    public const default = "default";
    public const low = "low";
    public const long = "long";
}
