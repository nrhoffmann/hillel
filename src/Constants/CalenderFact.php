<?php


namespace NRHoffmann\Hillel\Constants;


use NRHoffmann\Hillel\Traits\EffectivelyStatic;

final class CalenderFact
{
    use EffectivelyStatic;

    const LEAP_YEARS     = [0, 3, 6, 8, 11, 14, 17];
    const YEARS_IN_CYCLE = 19;
}