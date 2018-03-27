<?php


namespace Nrhoffmann\Tarich;


use const Nrhoffmann\Tarich\Constants\{
    LEAP_YEARS, YEARS_IN_CYCLE
};

class Tarich
{

    public static function isLeapYear(int $year): bool
    {
        $yearInCycle = $year % YEARS_IN_CYCLE;

        return in_array($yearInCycle, LEAP_YEARS);
    }
}