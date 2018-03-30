<?php


namespace NRHoffmann\Hillel;

use BadMethodCallException;
use Error;
use Exception;
use NRHoffmann\Hillel\Constants\DayOfWeek;
use NRHoffmann\Hillel\Constants\Month;

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

    public function dayOfWeek(): int
    {
        return jddayofweek(jewishtojd($this->month, $this->day, $this->year));
    }

    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////// Predicates //////////////////////////////
    ////////////////////////////////////////////////////////////////////////

    public function isSunday(): bool
    {
        return $this->dayOfWeek() === DayOfWeek::SUNDAY;
    }

    public function isMonday(): bool
    {
        return $this->dayOfWeek() === DayOfWeek::MONDAY;
    }

    public function isTuesday(): bool
    {
        return $this->dayOfWeek() === DayOfWeek::TUESDAY;
    }

    public function isWednesday(): bool
    {
        return $this->dayOfWeek() === DayOfWeek::WEDNESDAY;
    }

    public function isThursday(): bool
    {
        return $this->dayOfWeek() === DayOfWeek::THURSDAY;
    }

    public function isFriday(): bool
    {
        return $this->dayOfWeek() === DayOfWeek::FRIDAY;
    }

    public function isSaturday(): bool
    {
        return $this->dayOfWeek() === DayOfWeek::SATURDAY;
    }

    public function isErevRoshHashanah(): bool
    {
        return $this->month === Month::ELUL
            && $this->day === 29;
    }

    public function isRoshHashanahDay1(): bool
    {
        return $this->month === Month::TISHRI
            && $this->day === 1;
    }

    public function isRoshHashanahDay2(): bool
    {
        return $this->month === Month::TISHRI
            && $this->day === 2;
    }

    public function isTzomGedaliah(): bool
    {
        if (!$this->isSaturday()) {
            return $this->month === Month::TISHRI
                && $this->day === 3;
        }

        # If the 3rd of Tishri falls out on Saturday, Tzom Gedaliah is postponed to Sunday.
        return $this->month === Month::TISHRI
            && $this->day === 4;
    }

    public function isErevYomKippur(): bool
    {
        return $this->month === Month::TISHRI
            && $this->day === 9;
    }

    public function isYomKippur(): bool
    {
        return $this->month === Month::TISHRI
            && $this->day === 10;
    }

    public function isErevSukkot(): bool
    {
        return $this->month === Month::TISHRI
            && $this->day === 14;
    }

    public function isSukkotDay1(): bool
    {
        return $this->month === Month::TISHRI
            && $this->day === 15;
    }


    public function isSukkotDay2(): bool
    {
        return $this->month === Month::TISHRI
            && $this->day === 16;
    }

    public function isCholHamoedSukkot($diaspora = true
    ): bool {
        if ($this->month === Month::TISHRI) {
            if ($diaspora) {
                return $this->day >= 17
                    && $this->day <= 20;
            }

            return $this->day >= 16
                && $this->day <= 20;
        }

        return false;
    }

    public function isHoshanaRabbah(): bool
    {
        return $this->month === Month::TISHRI
            && $this->day === 21;
    }

    public function isSimchatTorah($diaspora = true
    ): bool {
        if ($diaspora) {
            return $this->month === Month::TISHRI
                && $this->day === 23;
        }

        return Luach::isSheminiAzeret($this);
    }

    public function isSheminiAzeret(): bool
    {
        return $this->month === Month::TISHRI
            && $this->day === 22;
    }

    public function isIsruChagSukkot($diaspora = true
    ): bool {
        if ($diaspora) {
            return $this->month === Month::TISHRI
                && $this->day === 24;
        }

        return $this->month === Month::TISHRI
            && $this->day === 23;
    }

    public function isHanukkahDay(int $day): bool
    {
        if ($day > 8 || $day < 1) {
            throw new BadMethodCallException();
        }

        $HanukkahStart = Tarich::create($this->year, Month::KISLEV, 25);
        $offset        = --$day;

        return $this->equals($HanukkahStart->addDays($offset));
    }

    public function isTzomTevet(): bool
    {
        if (!$this->isSaturday()) {
            return $this->month === Month::TEVET
                && $this->day === 10;
        }

        # If the 10th of Tevet falls out on Saturday, Tzom Tevet is postponed to Sunday.
        return $this->month === Month::TEVET
            && $this->day === 11;
    }

    public function isTuBShevat(): bool
    {
        return $this->month === Month::SHEVAT
            && $this->day === 15;
    }

    public function isPurimKatan(): bool
    {
        return $this->month === Month::ADAR_1
            && $this->day === 14;
    }

    public function isShushanPurimKatan(): bool
    {
        return $this->month === Month::ADAR_1
            && $this->day === 15;
    }

    public function isTanisEsther(): bool
    {
        if (!$this->isSaturday()) {
            return $this->month === Month::ADAR
                && $this->day === 13;
        }

        # If the 13th of Adar falls out on a Saturday, Tanis Esther occurs on the preceding Thursday
        return $this->month === Month::ADAR
            && $this->day === 11;
    }

    public function isPurim(): bool
    {
        return $this->month === Month::ADAR
            && $this->day === 14;
    }

    public function isShushanPurim(): bool
    {
        # INVESTIGATE: In some customs, Shushan Purim is postponed to Sunday if the 15th of Adar falls out on a Saturday.
        return $this->month === Month::ADAR
            && $this->day === 15;
    }

    public function isShabbatHagadol(): bool
    {
        $pesach         = Tarich::create($this->year, Month::NISAN, 15);
        $shabbatHagadol = $pesach->subWeek()->nextSaturday();

        return $this->equals($shabbatHagadol);
    }

    public function isErevPesach(): bool
    {
        return $this->month === Month::NISAN
            && $this->day === 14;
    }

    public function isPesachDay1(): bool
    {
        return $this->month === Month::NISAN
            && $this->day === 15;
    }


    public function isPesachDay2(): bool
    {
        return $this->month === Month::NISAN
            && $this->day === 16;
    }

    public function isCholHamoedPesach($diaspora = true
    ): bool {
        if ($this->month === Month::NISAN) {
            if ($diaspora) {
                return $this->day >= 17
                    && $this->day <= 20;
            }

            return $this->day >= 16
                && $this->day <= 20;
        }

        return false;
    }


    public function isPesachDay7(): bool
    {
        return $this->month === Month::NISAN
            && $this->day === 21;
    }

    public function isPesachDay8(): bool
    {
        return $this->month === Month::NISAN
            && $this->day === 22;
    }

    public function isIsruChagPesach($diaspora = true
    ): bool {
        if ($diaspora) {
            return $this->month === Month::NISAN
                && $this->day === 23;
        }

        return $this->month === Month::NISAN
            && $this->day === 22;
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

    public function isPesachSheini(): bool
    {
        return $this->month === Month::IYAR
            && $this->day === 14;
    }

    public function isLagBOmer(): bool
    {
        return $this->month === Month::IYAR
            && $this->day === 18;
    }

    public function isYomYerushalayim(): bool
    {
        return $this->month === Month::IYAR
            && $this->day === 28;
    }

    public function isErevShavuot(): bool
    {
        return $this->month === Month::SIVAN
            && $this->day === 5;
    }

    public function isShavuotDay1(): bool
    {
        return $this->month === Month::SIVAN
            && $this->day === 6;
    }


    public function isShavuotDay2(): bool
    {
        return $this->month === Month::SIVAN
            && $this->day === 7;
    }

    public function isIsruChagShavuot($diaspora = true
    ): bool {
        if ($diaspora) {
            return $this->month === Month::SIVAN
                && $this->day === 8;
        }

        return $this->month === Month::SIVAN
            && $this->day === 7;
    }

    public function isTzomTammuz(): bool
    {
        if (!$this->isSaturday()) {
            return $this->month === Month::TAMMUZ
                && $this->day === 17;
        }

        # If the 17th of Tammuz falls out on Saturday, Tzom Gedaliah is postponed to Sunday.
        return $this->month === Month::TAMMUZ
            && $this->day === 18;
    }

    public function isTishaBAv(): bool
    {
        if (!$this->isSaturday()) {
            return $this->month === Month::AV
                && $this->day === 9;
        }

        # If the 9th of Av falls out on Saturday, Tzom Gedaliah is postponed to Sunday.
        return $this->month === Month::AV
            && $this->day === 10;
    }

    public function isTuBAv(): bool
    {
        return $this->month === Month::AV
            && $this->day === 15;
    }

    public function isRoshChodesh(): bool
    {
        return $this->day === 1
            || $this->day === 30;
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