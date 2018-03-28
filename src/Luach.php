<?php


namespace NRHoffmann\Hillel;


use AssertionError;
use BadMethodCallException;
use const NRHoffmann\Hillel\Constants\ADAR;
use const NRHoffmann\Hillel\Constants\ADAR_1;
use const NRHoffmann\Hillel\Constants\AV;
use const NRHoffmann\Hillel\Constants\ELUL;
use const NRHoffmann\Hillel\Constants\IYAR;
use const NRHoffmann\Hillel\Constants\KISLEV;
use const NRHoffmann\Hillel\Constants\LEAP_YEARS;
use const NRHoffmann\Hillel\Constants\NISAN;
use const NRHoffmann\Hillel\Constants\SHEVAT;
use const NRHoffmann\Hillel\Constants\SIVAN;
use const NRHoffmann\Hillel\Constants\TAMMUZ;
use const NRHoffmann\Hillel\Constants\TEVET;
use const NRHoffmann\Hillel\Constants\TISHRI;
use const NRHoffmann\Hillel\Constants\YEARS_IN_CYCLE;

final class Luach
{

    /**
     * Luach constructor.
     *
     * The Luach class is effectively static, thus should never be instantiated.
     * The constructor does nothing more than enforce that, and will throw an
     * error if called internally or using reflection.
     *
     * @throws \AssertionError
     */
    private function __construct()
    {
        throw new AssertionError('this shouldn\'t be called');
    }

    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////// Predicates //////////////////////////////
    ////////////////////////////////////////////////////////////////////////

    public static function isLeapYear(int $year): bool
    {
        $yearInCycle = $year % YEARS_IN_CYCLE;

        return in_array($yearInCycle, LEAP_YEARS);
    }

    public static function isErevRoshHashanah(Tarich $tarich): bool
    {
        return $tarich->month === ELUL
            && $tarich->day === 29;
    }

    public static function isRoshHashanahDay1(Tarich $tarich): bool
    {
        return $tarich->month === TISHRI
            && $tarich->day === 1;
    }

    public static function isRoshHashanahDay2(Tarich $tarich): bool
    {
        return $tarich->month === TISHRI
            && $tarich->day === 2;
    }

    public static function isTzomGedaliah(Tarich $tarich): bool
    {
        if (!$tarich->isSaturday()) {
            return $tarich->month === TISHRI
                && $tarich->day === 3;
        }

        # If the 3rd of Tishri falls out on Saturday, Tzom Gedaliah is postponed to Sunday.
        return $tarich->month === TISHRI
            && $tarich->day === 4;
    }

    public static function isErevYomKippur(Tarich $tarich): bool
    {
        return $tarich->month === TISHRI
            && $tarich->day === 9;
    }

    public static function isYomKippur(Tarich $tarich): bool
    {
        return $tarich->month === TISHRI
            && $tarich->day === 10;
    }

    public static function isErevSukkot(Tarich $tarich): bool
    {
        return $tarich->month === TISHRI
            && $tarich->day === 14;
    }

    public static function isSukkotDay1(Tarich $tarich): bool
    {
        return $tarich->month === TISHRI
            && $tarich->day === 15;
    }


    public static function isSukkotDay2(Tarich $tarich): bool
    {
        return $tarich->month === TISHRI
            && $tarich->day === 16;
    }

    public static function isCholHamoedSukkot(Tarich $tarich, $diaspora = true
    ): bool {
        if ($tarich->month === TISHRI) {
            if ($diaspora) {
                return $tarich->day >= 17
                    && $tarich->day <= 20;
            }

            return $tarich->day >= 16
                && $tarich->day <= 20;
        }

        return false;
    }

    public static function isHoshanaRabbah(Tarich $tarich): bool
    {
        return $tarich->month === TISHRI
            && $tarich->day === 21;
    }

    public static function isSimchatTorah(Tarich $tarich, $diaspora = true
    ): bool {
        if ($diaspora) {
            return $tarich->month === TISHRI
                && $tarich->day === 23;
        }

        return Luach::isSheminiAzeret($tarich);
    }

    public static function isSheminiAzeret(Tarich $tarich): bool
    {
        return $tarich->month === TISHRI
            && $tarich->day === 22;
    }

    public static function isIsruChagSukkot(Tarich $tarich, $diaspora = true
    ): bool {
        if ($diaspora) {
            return $tarich->month === TISHRI
                && $tarich->day === 24;
        }

        return $tarich->month === TISHRI
            && $tarich->day === 23;
    }

    public static function isHanukkahDay(int $day, Tarich $tarich): bool
    {
        if ($day > 8 || $day < 1) {
            throw new BadMethodCallException();
        }

        $HanukkahStart = Tarich::create($tarich->year, KISLEV, 25);
        $offset        = --$day;

        return $tarich->equals($HanukkahStart->addDays($offset));
    }

    public static function isTzomTevet(Tarich $tarich): bool
    {
        if (!$tarich->isSaturday()) {
            return $tarich->month === TEVET
                && $tarich->day === 10;
        }

        # If the 10th of Tevet falls out on Saturday, Tzom Tevet is postponed to Sunday.
        return $tarich->month === TEVET
            && $tarich->day === 11;
    }

    public static function isTuBShevat(Tarich $tarich): bool
    {
        return $tarich->month === SHEVAT
            && $tarich->day === 15;
    }

    public static function isPurimKatan(Tarich $tarich): bool
    {
        return $tarich->month === ADAR_1
            && $tarich->day === 14;
    }

    public static function isShushanPurimKatan(Tarich $tarich): bool
    {
        return $tarich->month === ADAR_1
            && $tarich->day === 15;
    }

    public static function isTanisEsther(Tarich $tarich): bool
    {
        if (!$tarich->isSaturday()) {
            return $tarich->month === ADAR
                && $tarich->day === 13;
        }

        # If the 13th of Adar falls out on a Saturday, Tanis Esther occurs on the preceding Thursday
        return $tarich->month === ADAR
            && $tarich->day === 11;
    }

    public static function isPurim(Tarich $tarich): bool
    {
        return $tarich->month === ADAR
            && $tarich->day === 14;
    }

    public static function isShushanPurim(Tarich $tarich): bool
    {
        # INVESTIGATE: In some customs, Shushan Purim is postponed to Sunday if the 15th of Adar falls out on a Saturday.
        return $tarich->month === ADAR
            && $tarich->day === 15;
    }

    public static function isShabbatHagadol(Tarich $tarich): bool
    {
        $pesach         = Tarich::create($tarich->year, NISAN, 15);
        $shabbatHagadol = $pesach->subWeek()->nextSaturday();

        return $tarich->equals($shabbatHagadol);
    }

    public static function isErevPesach(Tarich $tarich): bool
    {
        return $tarich->month === NISAN
            && $tarich->day === 14;
    }

    public static function isPesachDay1(Tarich $tarich): bool
    {
        return $tarich->month === NISAN
            && $tarich->day === 15;
    }


    public static function isPesachDay2(Tarich $tarich): bool
    {
        return $tarich->month === NISAN
            && $tarich->day === 16;
    }

    public static function isCholHamoedPesach(Tarich $tarich, $diaspora = true
    ): bool {
        if ($tarich->month === NISAN) {
            if ($diaspora) {
                return $tarich->day >= 17
                    && $tarich->day <= 20;
            }

            return $tarich->day >= 16
                && $tarich->day <= 20;
        }

        return false;
    }


    public static function isPesachDay7(Tarich $tarich): bool
    {
        return $tarich->month === NISAN
            && $tarich->day === 21;
    }

    public static function isPesachDay8(Tarich $tarich): bool
    {
        return $tarich->month === TISHRI
            && $tarich->day === 22;
    }

    public static function isIsruChagPesach(Tarich $tarich, $diaspora = true
    ): bool {
        if ($diaspora) {
            return $tarich->month === TISHRI
                && $tarich->day === 23;
        }

        return $tarich->month === TISHRI
            && $tarich->day === 22;
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

    public static function isPesachSheini(Tarich $tarich): bool
    {
        return $tarich->month === IYAR
            && $tarich->day === 14;
    }

    public static function isLagBOmer(Tarich $tarich): bool
    {
        return $tarich->month === IYAR
            && $tarich->day === 18;
    }

    public static function isYomYerushalayim(Tarich $tarich): bool
    {
        return $tarich->month === IYAR
            && $tarich->day === 28;
    }

    public static function isErevShavuot(Tarich $tarich): bool
    {
        return $tarich->month === SIVAN
            && $tarich->day === 5;
    }

    public static function isShavuotDay1(Tarich $tarich): bool
    {
        return $tarich->month === SIVAN
            && $tarich->day === 6;
    }


    public static function isShavuotDay2(Tarich $tarich): bool
    {
        return $tarich->month === SIVAN
            && $tarich->day === 7;
    }

    public static function isIsruChagShavuot(Tarich $tarich, $diaspora = true
    ): bool {
        if ($diaspora) {
            return $tarich->month === SIVAN
                && $tarich->day === 8;
        }

        return $tarich->month === SIVAN
            && $tarich->day === 7;
    }

    public static function isTzomTammuz(Tarich $tarich): bool
    {
        if (!$tarich->isSaturday()) {
            return $tarich->month === TAMMUZ
                && $tarich->day === 17;
        }

        # If the 17th of Tammuz falls out on Saturday, Tzom Gedaliah is postponed to Sunday.
        return $tarich->month === TAMMUZ
            && $tarich->day === 18;
    }

    public static function isTishaBAv(Tarich $tarich): bool
    {
        if (!$tarich->isSaturday()) {
            return $tarich->month === AV
                && $tarich->day === 9;
        }

        # If the 9th of Av falls out on Saturday, Tzom Gedaliah is postponed to Sunday.
        return $tarich->month === AV
            && $tarich->day === 10;
    }

    public static function isTuBAv(Tarich $tarich): bool
    {
        return $tarich->month === AV
            && $tarich->day === 15;
    }

    public static function isRoshChodesh(Tarich $tarich): bool
    {
        return $tarich->day === 1
            || $tarich->day === 30;
    }
}