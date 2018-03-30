<?php


namespace NRHoffmann\Hillel\Constants;


use NRHoffmann\Hillel\Traits\EffectivelyStatic;
use NRHoffmann\Hillel\Traits\EnumerableConstants;

final class DayOfWeek
{
    use EnumerableConstants;
    use EffectivelyStatic;

    const SUNDAY    = 0;
    const MONDAY    = 1;
    const TUESDAY   = 2;
    const WEDNESDAY = 3;
    const THURSDAY  = 4;
    const FRIDAY    = 5;
    const SATURDAY  = 6;
}