<?php


namespace NRHoffmann\Hillel;


use NRHoffmann\Hillel\Constants\CalenderFact;
use NRHoffmann\Hillel\Traits\EffectivelyStatic;

final class Luach
{
    use EffectivelyStatic;

    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////// Predicates //////////////////////////////
    ////////////////////////////////////////////////////////////////////////

    public static function isLeapYear(int $year): bool
    {
        $yearInCycle = $year % CalenderFact::YEARS_IN_CYCLE;

        return in_array($yearInCycle, CalenderFact::LEAP_YEARS);
    }
}