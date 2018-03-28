<?php


namespace NRHoffmann\Hillel;

use Error;
use Exception;
use const NRHoffmann\Hillel\Constants\FRIDAY;
use const NRHoffmann\Hillel\Constants\MONDAY;
use const NRHoffmann\Hillel\Constants\SATURDAY;
use const NRHoffmann\Hillel\Constants\SUNDAY;
use const NRHoffmann\Hillel\Constants\THURSDAY;
use const NRHoffmann\Hillel\Constants\TUESDAY;
use const NRHoffmann\Hillel\Constants\WEDNESDAY;

/**
 * Class Tarich.
 *
 * @property-read $day
 * @property-read $month
 * @property-read $year
 *
 * @package NRHoffmann\Tarich
 */
final class Tarich
{

    private $day;

    private $month;

    private $year;

    public function __construct($month, $day, $year)
    {
        $this->day   = $day;
        $this->month = $month;
        $this->year  = $year;
    }

    public static function create($month, $day, $year): Tarich
    {
        return new Tarich($month, $day, $year);
    }

    public function createGorgarian($month, $day, $year): Tarich
    {
        $julianDayNumber  = gregoriantojd($month, $day, $year);
        $jewishDateString = jdtojewish($julianDayNumber);

        return Tarich::parse($jewishDateString);
    }

    public static function parse($string, $format = ['month', 'day', 'year']
    ): Tarich {
        $group   = '/[\d]+/';
        $matches = [];
        $args    = [];

        preg_match_all($group, $string, $matches);
        foreach ($matches[0] as $key => $value) {
            $arg        = $format[$key];
            $args[$arg] = intval($value);
        }

        try {
            return Tarich::constructWith($args);
        } catch (Exception $exception) {

        }
    }

    /**
     * @param $args
     *
     * @return Tarich
     * @throws \Exception
     */
    private static function constructWith($args): Tarich
    {
        $month = null;
        $day   = null;
        $year  = null;

        extract($args, EXTR_IF_EXISTS);

        if (is_null($month) || is_null($day) || is_null($year)) {
            throw new Exception();
        }

        return new Tarich($month, $day, $year);
    }

    /**
     * Magic getter.
     *
     * Provides readonly access to the parts of a tarich.
     *
     * @param $name
     *
     * @return mixed
     * @throws \Error
     */
    public function __get($name)
    {
        switch (true) {
            case $name === 'day':
                return $this->day;
            case $name === 'month':
                return $this->month;
            case $name === 'year':
                return $this->year;
            default:
                throw new Error();
        }
    }

    public function __toString()
    {
        return join("-", [$this->month, $this->day, $this->year]);
    }

    public function equals(Tarich $that): bool
    {
        return $this->day === $that->day
            && $this->month === $that->month
            && $this->year === $that->year;
    }

    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////// Predicates //////////////////////////////
    ////////////////////////////////////////////////////////////////////////

    public function isSunday(): bool
    {
        return $this->dayOfWeek() === SUNDAY;
    }

    public function dayOfWeek(): int
    {
        return jddayofweek(jewishtojd($this->month, $this->day, $this->year));
    }

    public function isMonday(): bool
    {
        return $this->dayOfWeek() === MONDAY;
    }

    public function isTuesday(): bool
    {
        return $this->dayOfWeek() === TUESDAY;
    }

    public function isWednesday(): bool
    {
        return $this->dayOfWeek() === WEDNESDAY;
    }

    public function isThursday(): bool
    {
        return $this->dayOfWeek() === THURSDAY;
    }

    public function isFriday(): bool
    {
        return $this->dayOfWeek() === FRIDAY;
    }

    public function isSaturday(): bool
    {
        return $this->dayOfWeek() === SATURDAY;
    }

    public function isLeapYear(): bool
    {
        return Luach::isLeapYear($this->year);
    }

    public function isErevRoshHashanah(): bool
    {
        return Luach::isErevRoshHashanah($this);
    }

    public function isRoshHashanahDay1(): bool
    {
        return Luach::isRoshHashanahDay1($this);
    }

    public function isRoshHashanahDay2(): bool
    {
        return Luach::isRoshHashanahDay2($this);
    }

    public function isTzomGedaliah(): bool
    {
        return Luach::isTzomGedaliah($this);
    }

    public function isErevYomKippur(): bool
    {
        return Luach::isErevYomKippur($this);
    }

    public function isYomKippur(): bool
    {
        return Luach::isYomKippur($this);
    }

    public function isErevSukkot(): bool
    {
        return Luach::isErevSukkot($this);
    }

    public function isSukkotDay1(): bool
    {
        return Luach::isSukkotDay1($this);
    }

    public function isSukkotDay2(): bool
    {
        return Luach::isSukkotDay2($this);
    }

    public function isCholHamoedSukkot($diaspora = true): bool
    {
        return Luach::isCholHamoedSukkot($this, $diaspora);
    }

    public function isHoshanaRabbah(): bool
    {
        return Luach::isHoshanaRabbah($this);
    }

    public function isSimchatTorah($diaspora = true): bool
    {
        return Luach::isSimchatTorah($this, $diaspora);
    }

    public function isSheminiAzeret(): bool
    {
        return Luach::isSheminiAzeret($this);
    }

    public function isIsruChagSukkot($diaspora = true): bool
    {
        return Luach::isIsruChagSukkot($this, $diaspora);
    }

    public function isHanukkahDay(int $day): bool
    {
        return Luach::isHanukkahDay($day, $this);
    }

    public function isTzomTevet(): bool
    {
        return Luach::isTzomTevet($this);
    }

    public function isTuBShevat(): bool
    {
        return Luach::isTuBShevat($this);
    }

    public function isPurimKatan(): bool
    {
        return Luach::isPurimKatan($this);
    }

    public function isShushanPurimKatan(): bool
    {
        return Luach::isShushanPurimKatan($this);
    }

    public function isTanisEsther(): bool
    {
        return Luach::isTanisEsther($this);
    }

    public function isPurim(): bool
    {
        return Luach::isPurim($this);
    }

    public function isShushanPurim(): bool
    {
        return Luach::isShushanPurim($this);
    }

    public function isShabbatHagadol(): bool
    {
        return Luach::isShabbatHagadol($this);
    }

    public function isErevPesach(): bool
    {
        return Luach::isErevPesach($this);
    }

    public function isPesachDay1(): bool
    {
        return Luach::isPesachDay1($this);

    }

    public function isPesachDay2(): bool
    {
        return Luach::isPesachDay2($this);

    }

    public function isCholHamoedPesach($diaspora = true): bool
    {
        return Luach::isCholHamoedPesach($this, $diaspora);
    }

    public function isPesachDay7(): bool
    {
        return Luach::isPesachDay7($this);

    }

    public function isPesachDay8(): bool
    {
        return Luach::isPesachDay8($this);

    }

    # TODO: Israeli Holidays...

    /*
     * Yom Hashoah
     * 27 Nisan
     * If the 27 Nisan falls on Friday, then Yom Hashoah falls on Thursday.
     * Since 1997 (5757), Yom Hashoah is postponed to Monday if the 27 Nisan falls on Sunday.
     *
     * Yom Hazikaron
     * 4 Iyar
     * If the 4 Iyar falls on a Friday or Thursday, then Yom Hazicaron occurs on the preceding Wednesday.
     * For years of 2004 and later, if the 4 Iyar falls on a Sunday, Yom Hazikaron is postponed by one day.
     *
     * Yom Ha'Atzmaut
     * 5 Iyar
     * If the 5 Iyar falls on a Saturday or Friday, then Yom Ha'Atzmaut occurs on the preceding Thursday.
     * For years of 2004 and later, if the 4 Iyar falls on a Sunday, Yom Ha'Atzmaut is postponed by one day.
     */

    public function isIsruChagPesach($diaspora = true): bool
    {
        return Luach::isIsruChagPesach($this, $diaspora);
    }

    public function isPesachSheini(): bool
    {
        return Luach::isPesachSheini($this);
    }

    public function isLagBOmer(): bool
    {
        return Luach::isLagBOmer($this);
    }

    public function isYomYerushalayim(): bool
    {
        return Luach::isYomYerushalayim($this);
    }

    public function isErevShavuot(): bool
    {
        return Luach::isErevShavuot($this);
    }

    public function isShavuotDay1(): bool
    {
        return Luach::isShavuotDay1($this);
    }

    public function isShavuotDay2(): bool
    {
        return Luach::isShavuotDay2($this);

    }

    public function isIsruChagShavuot($diaspora = true): bool
    {
        return Luach::isIsruChagShavuot($this, $diaspora);
    }

    public function isTzomTammuz(): bool
    {
        return Luach::isTzomTammuz($this);
    }

    public function isTishaBAv(): bool
    {
        return Luach::isTishaBAv($this);
    }

    public function isTuBAv(): bool
    {
        return Luach::isTuBAv($this);
    }

    public function isRoshChodesh(): bool
    {
        return Luach::isRoshChodesh($this);
    }

    ////////////////////////////////////////////////////////////////////////
    /////////////////////////////// Mutators ///////////////////////////////
    ////////////////////////////////////////////////////////////////////////

    public function addDay($days): Tarich
    {
        $this->addDays(1);

        return $this;

    }

    public function addDays($days): Tarich
    {
        # TODO
        return $this;
    }

    public function addWeek($weeks): Tarich
    {
        $this->addWeeks(1);

        return $this;
    }

    public function addWeeks($weeks): Tarich
    {
        # TODO
        return $this;
    }

    public function addYear($years): Tarich
    {
        $this->addYears(1);

        return $this;
    }

    public function addYears($years): Tarich
    {
        # TODO
        return $this;
    }

    public function subDay($days): Tarich
    {
        $this->subDays(1);

        return $this;

    }

    public function subDays($days): Tarich
    {
        # TODO
        return $this;
    }

    public function subWeek($weeks): Tarich
    {
        $this->subWeeks(1);

        return $this;
    }

    public function subWeeks($weeks): Tarich
    {
        # TODO
        return $this;
    }

    public function subYear($years): Tarich
    {
        $this->subYears(1);

        return $this;
    }

    public function subYears($years): Tarich
    {
        # TODO
        return $this;
    }

    public function nextSaturday(): Tarich
    {
    }
}