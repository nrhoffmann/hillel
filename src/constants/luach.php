<?php

namespace NRHoffmann\Hillel\Constants;

const LEAP_YEARS     = [0, 3, 6, 8, 11, 14, 17];
const YEARS_IN_CYCLE = 19;

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

const TISHRI_NAME  = 'Tishri';
const HESHVAN_NAME = 'Heshvan';
const KISLEV_NAME  = 'Kislev';
const TEVET_NAME   = 'Tevet';
const SHEVAT_NAME  = 'Shevat';
const ADAR_NAME    = 'Adar';
const ADAR_1_NAME  = 'Adar I';
const ADAR_2_NAME  = 'Adar II';
const NISAN_NAME   = 'Nisan';
const IYAR_NAME    = 'Iyar';
const SIVAN_NAME   = 'Sivan';
const TAMMUZ_NAME  = 'Tammuz';
const AV_NAME      = 'Av';
const ELUL_NAME    = 'Elul';

const NAMES_OF_MONTHS
= [
    TISHRI  => TISHRI_NAME,
    HESHVAN => HESHVAN_NAME,
    KISLEV  => KISLEV_NAME,
    TEVET   => TEVET_NAME,
    SHEVAT  => SHEVAT_NAME,
    ADAR    => ADAR_NAME,
    NISAN   => NISAN_NAME,
    IYAR    => IYAR_NAME,
    SIVAN   => SIVAN_NAME,
    TAMMUZ  => TAMMUZ_NAME,
    AV      => AV_NAME,
    ELUL    => ELUL_NAME,
];

const NAMES_OF_MONTHS_ON_LEAP_YEAR
= [
    TISHRI  => TISHRI_NAME,
    HESHVAN => HESHVAN_NAME,
    KISLEV  => KISLEV_NAME,
    TEVET   => TEVET_NAME,
    SHEVAT  => SHEVAT_NAME,
    ADAR_1  => ADAR_1_NAME,
    ADAR_2  => ADAR_2_NAME,
    NISAN   => NISAN_NAME,
    IYAR    => IYAR_NAME,
    SIVAN   => SIVAN_NAME,
    TAMMUZ  => TAMMUZ_NAME,
    AV      => AV_NAME,
    ELUL    => ELUL_NAME,
];

const SUNDAY    = 0;
const MONDAY    = 1;
const TUESDAY   = 2;
const WEDNESDAY = 3;
const THURSDAY  = 4;
const FRIDAY    = 5;
const SATURDAY  = 6;