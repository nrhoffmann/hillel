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
 * @property-read $dow
 *
 * @package NRHoffmann\Tarich
 */
final class Tarich
{
    private $daysPastJulianEpoch;

    private function __construct($daysPastJulianEpoch)
    {
        $this->daysPastJulianEpoch = $daysPastJulianEpoch;
    }

    public static function fromJewish($month, $day, $year): Tarich
    {
        return new Tarich(jewishtojd($month, $day, $year));
    }

    public static function fromGorgarian($month, $day, $year): Tarich
    {
        return new Tarich(gregoriantojd($month, $day, $year));
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
        $computedDate = cal_from_jd($this->daysPastJulianEpoch, CAL_JEWISH);

        switch (true) {
            case $name === 'day':
            case $name === 'month':
            case $name === 'year':
            case $name === 'dow':
                return $computedDate[$name];
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
        return $this->dow === DayOfWeek::SUNDAY;
    }

    public function isMonday(): bool
    {
        return $this->dow === DayOfWeek::MONDAY;
    }

    public function isTuesday(): bool
    {
        return $this->dow === DayOfWeek::TUESDAY;
    }

    public function isWednesday(): bool
    {
        return $this->dow === DayOfWeek::WEDNESDAY;
    }

    public function isThursday(): bool
    {
        return $this->dow === DayOfWeek::THURSDAY;
    }

    public function isFriday(): bool
    {
        return $this->dow === DayOfWeek::FRIDAY;
    }

    public function isSaturday(): bool
    {
        return $this->dow === DayOfWeek::SATURDAY;
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
        # If the 3rd of Tishri falls out on Saturday, Tzom Gedaliah is postponed to Sunday.
        if (Tarich::fromJewish(Month::TISHRI, 3, $this->year)->isSaturday()) {
            return $this->month === Month::TISHRI
                && $this->day === 4;
        }

        return $this->month === Month::TISHRI
            && $this->day === 3;
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

        return $this->isSheminiAzeret();
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

        $HanukkahStart = Tarich::fromJewish($this->year, Month::KISLEV, 25);
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
        $pesach         = Tarich::fromJewish($this->year, Month::NISAN, 15);
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
        $this->daysPastJulianEpoch += $days;
        return $this;
    }

    public function subDay($days): Tarich
    {
        $this->subDays(1);

        return $this;

    }

    public function subDays($days): Tarich
    {
        $this->addDay(-$days);
        return $this;
    }
}