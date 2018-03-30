<?php


namespace NRHoffmann\Hillel\Constants;


use NRHoffmann\Hillel\Traits\EffectivelyStatic;

final class Month
{
    use EffectivelyStatic;

    const TISHRI  = 1;
    const HESHVAN = 2;
    const KISLEV  = 3;
    const TEVET   = 4;
    const SHEVAT  = 5;
    const ADAR    = 7;
    const ADAR_1  = 6;
    const ADAR_2  = 7;
    const NISAN   = 8;
    const IYAR    = 9;
    const SIVAN   = 10;
    const TAMMUZ  = 11;
    const AV      = 12;
    const ELUL    = 13;

    const NAMES = [
        self::TISHRI => 'Tishri',
        self::HESHVAN => 'Heshvan',
        self::KISLEV => 'Kislev',
        self::TEVET  => 'Tevet',
        self::SHEVAT => 'Shevat',
        self::ADAR   => 'Adar',
        self::NISAN  => 'Nisan',
        self::IYAR   => 'Iyar',
        self::SIVAN  => 'Sivan',
        self::TAMMUZ => 'Tammuz',
        self::AV     => 'Av',
        self::ELUL   => 'Elul'
    ];

    const NAMES_LEAP_YEAR = [
        self::TISHRI => self::NAMES[self::TISHRI],
        self::HESHVAN => self::NAMES[self::HESHVAN],
        self::KISLEV => self::NAMES[self::KISLEV],
        self::TEVET  => self::NAMES[self::TEVET],
        self::SHEVAT => self::NAMES[self::SHEVAT],
        self::ADAR_1 => 'Adar I',
        self::ADAR_2 => 'Adar II',
        self::NISAN  => self::NAMES[self::NISAN],
        self::IYAR   => self::NAMES[self::IYAR],
        self::SIVAN  => self::NAMES[self::SIVAN],
        self::TAMMUZ => self::NAMES[self::TAMMUZ],
        self::AV     => self::NAMES[self::AV],
        self::ELUL   => self::NAMES[self::ELUL]
    ];
}