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
    const urgent = "urgent";
    const high = "high";
    const default = "default";
    const low = "low";
    const long = "long";
}
