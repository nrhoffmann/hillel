<?php


use NRHoffmann\Hillel\Tarich;
use PHPUnit\Framework\TestCase;

class TarichTest extends TestCase
{

    public function testMagicGetOnYear()
    {
        $tarich = Tarich::fromJewish(9, 3, 5776);
        $this->assertEquals(5776, $tarich->year);
    }

    public function testMagicGetOnMonth()
    {
        $tarich = Tarich::fromJewish(9, 3, 5776);
        $this->assertEquals(9, $tarich->month);
    }

    public function testMagicGetOnDay()
    {
        $tarich = Tarich::fromJewish(9, 3, 5776);
        $this->assertEquals(3, $tarich->day);
    }

    public function testMagicGetOnDayOfWeek()
    {
        $tarich = Tarich::fromGorgarian(4, 3, 2018);
        $this->assertEquals(2, $tarich->dow);
    }

    public function testToString()
    {
        $tarich = Tarich::fromJewish(7, 14, 5774);
        $this->assertEquals('7-14-5774', strval($tarich));
    }

    public function testCreateGorgarian()
    {
        $tarich = Tarich::fromGorgarian(3, 29, 2018);

        $this->assertEquals(8, $tarich->month);
        $this->assertEquals(13, $tarich->day);
        $this->assertEquals(5778, $tarich->year);
    }

    public function testIsSunday()
    {
        $tarich = Tarich::fromGorgarian(3, 25, 2018);

        $this->assertTrue($tarich->isSunday());
    }

    public function testIsMonday()
    {
        $tarich = Tarich::fromGorgarian(3, 26, 2018);

        $this->assertTrue($tarich->isMonday());
    }

    public function testIsTuesday()
    {
        $tarich = Tarich::fromGorgarian(3, 27, 2018);

        $this->assertTrue($tarich->isTuesday());
    }

    public function testIsWednesday()
    {
        $tarich = Tarich::fromGorgarian(3, 28, 2018);

        $this->assertTrue($tarich->isWednesday());
    }

    public function testIsThursday()
    {
        $tarich = Tarich::fromGorgarian(3, 29, 2018);

        $this->assertTrue($tarich->isThursday());
    }

    public function testIsFriday()
    {
        $tarich = Tarich::fromGorgarian(3, 30, 2018);

        $this->assertTrue($tarich->isFriday());
    }

    public function testIsSaturday()
    {
        $tarich = Tarich::fromGorgarian(3, 31, 2018);

        $this->assertTrue($tarich->isSaturday());
    }

    public function testEquals()
    {
        $tarich1 = Tarich::fromGorgarian(5, 10, 2000);
        $tarich2 = Tarich::fromGorgarian(12, 31, 1996);

        $this->assertTrue($tarich1->equals($tarich1));
        $this->assertFalse($tarich1->equals($tarich2));
    }

    public function testIsErevPassover()
    {
        $tarich = Tarich::fromJewish(8, 14, 5778);

        $this->assertTrue($tarich->isErevPesach());
    }

    public function testIsErevRoshHashanah()
    {
        $tarich = Tarich::fromJewish(13, 29, 5778);

        $this->assertTrue($tarich->isErevRoshHashanah());
    }

    public function testIsRoshHashanahDay1()
    {
        $tarich = Tarich::fromJewish(1, 1, 5778);

        $this->assertTrue($tarich->isRoshHashanahDay1());
    }

    public function testIsRoshHashanahDay2()
    {
        $tarich = Tarich::fromJewish(1, 2, 5778);

        $this->assertTrue($tarich->isRoshHashanahDay2());
    }

    public function testIsTzomGedaliah()
    {
        $tarich1 = Tarich::fromJewish(1, 4, 5778);
        $tarich2 = Tarich::fromJewish(1, 3, 5779);

        $this->assertTrue($tarich1->isTzomGedaliah());
        $this->assertTrue($tarich2->isTzomGedaliah());
    }

    public function testIsErevYomKippur()
    {
        $tarich = Tarich::fromJewish(1, 9, 5778);

        $this->assertTrue($tarich->isErevYomKippur());
    }

    public function testIsYomKippur()
    {
        $tarich = Tarich::fromJewish(1, 10, 5778);

        $this->assertTrue($tarich->isYomKippur());
    }

    public function testIsErevSukkot()
    {
        $tarich = Tarich::fromJewish(1, 14, 5778);

        $this->assertTrue($tarich->isErevSukkot());
    }

    public function testIsSukkotDay1()
    {
        $tarich = Tarich::fromJewish(1, 15, 5778);

        $this->assertTrue($tarich->isSukkotDay1());
    }

    public function testIsSukkotDay2()
    {
        $tarich = Tarich::fromJewish(1, 16, 5778);

        $this->assertTrue($tarich->isSukkotDay2());
    }

    public function testIsCholHamoedSukkot()
    {
        $tarich1 = Tarich::fromJewish(1, 16, 5778);
        $tarich2 = Tarich::fromJewish(1, 17, 5778);
        $tarich3 = Tarich::fromJewish(1, 18, 5778);
        $tarich4 = Tarich::fromJewish(1, 19, 5778);
        $tarich5 = Tarich::fromJewish(1, 20, 5778);

        $this->assertTrue($tarich1->isCholHamoedSukkot(false));
        $this->assertFalse($tarich1->isCholHamoedSukkot());

        $this->assertTrue($tarich2->isCholHamoedSukkot(false));
        $this->assertTrue($tarich2->isCholHamoedSukkot());

        $this->assertTrue($tarich3->isCholHamoedSukkot(false));
        $this->assertTrue($tarich3->isCholHamoedSukkot());

        $this->assertTrue($tarich4->isCholHamoedSukkot(false));
        $this->assertTrue($tarich4->isCholHamoedSukkot());

        $this->assertTrue($tarich5->isCholHamoedSukkot(false));
        $this->assertTrue($tarich5->isCholHamoedSukkot());
    }

    public function testIsCholHamoedPesach()
    {
        $tarich1 = Tarich::fromJewish(8, 16, 5778);
        $tarich2 = Tarich::fromJewish(8, 17, 5778);
        $tarich3 = Tarich::fromJewish(8, 18, 5778);
        $tarich4 = Tarich::fromJewish(8, 19, 5778);
        $tarich5 = Tarich::fromJewish(8, 20, 5778);

        $this->assertTrue($tarich1->isCholHamoedPesach(false));
        $this->assertFalse($tarich1->isCholHamoedPesach());

        $this->assertTrue($tarich2->isCholHamoedPesach(false));
        $this->assertTrue($tarich2->isCholHamoedPesach());

        $this->assertTrue($tarich3->isCholHamoedPesach(false));
        $this->assertTrue($tarich3->isCholHamoedPesach());

        $this->assertTrue($tarich4->isCholHamoedPesach(false));
        $this->assertTrue($tarich4->isCholHamoedPesach());

        $this->assertTrue($tarich5->isCholHamoedPesach(false));
        $this->assertTrue($tarich5->isCholHamoedPesach());
    }

    public function testIsHoshanaRabbah()
    {
        $tarich = Tarich::fromJewish(1, 21, 5778);

        $this->assertTrue($tarich->isHoshanaRabbah());
    }

    public function testIsSimchatTorah()
    {
        $tarich1 = Tarich::fromJewish(1, 22, 5778);
        $tarich2 = Tarich::fromJewish(1, 23, 5778);

        $this->assertTrue($tarich1->isSimchatTorah(false));
        $this->assertFalse($tarich1->isSimchatTorah());

        $this->assertFalse($tarich2->isSimchatTorah(false));
        $this->assertTrue($tarich2->isSimchatTorah());
    }

    public function testIsSheminiAzeret()
    {
        $tarich = Tarich::fromJewish(1, 22, 5778);

        $this->assertTrue($tarich->isSheminiAzeret());
    }

    public function testIsIsruChagSukkot() {
        $tarich1 = Tarich::fromJewish(1, 23, 5778);
        $tarich2 = Tarich::fromJewish(1, 24, 5778);

        $this->assertTrue($tarich1->isIsruChagSukkot(false));
        $this->assertFalse($tarich1->isIsruChagSukkot());

        $this->assertFalse($tarich2->isIsruChagSukkot(false));
        $this->assertTrue($tarich2->isIsruChagSukkot());
    }
    
    public function testIsIsruChagPesach() {
        $tarich1 = Tarich::fromJewish(8, 22, 5778);
        $tarich2 = Tarich::fromJewish(8, 23, 5778);

        $this->assertTrue($tarich1->isIsruChagPesach(false));
        $this->assertFalse($tarich1->isIsruChagPesach());

        $this->assertFalse($tarich2->isIsruChagPesach(false));
        $this->assertTrue($tarich2->isIsruChagPesach());
    }
    
    public function testIsHanukkahDay1()
    {
        $tarich = Tarich::fromJewish(3, 25, 5778);

        $this->assertTrue($tarich->isHanukkahDay1());
        $this->assertTrue($tarich->isHanukkahDayAny());
    }

    public function testIsHanukkahDay2()
    {
        $tarich = Tarich::fromJewish(3, 26, 5778);

        $this->assertTrue($tarich->isHanukkahDay2());
        $this->assertTrue($tarich->isHanukkahDayAny());
    }

    public function testIsHanukkahDay3()
    {
        $tarich = Tarich::fromJewish(3, 27, 5778);

        $this->assertTrue($tarich->isHanukkahDay3());
        $this->assertTrue($tarich->isHanukkahDayAny());
    }

    public function testIsHanukkahDay4()
    {
        $tarich = Tarich::fromJewish(3, 28, 5778);

        $this->assertTrue($tarich->isHanukkahDay4());
        $this->assertTrue($tarich->isHanukkahDayAny());
    }

    public function testIsHanukkahDay5()
    {
        $tarich = Tarich::fromJewish(3, 29, 5778);

        $this->assertTrue($tarich->isHanukkahDay5());
        $this->assertTrue($tarich->isHanukkahDayAny());
    }

    public function testIsHanukkahDay6()
    {
        $tarich = Tarich::fromJewish(3, 30, 5778);

        $this->assertTrue($tarich->isHanukkahDay6());
        $this->assertTrue($tarich->isHanukkahDayAny());
    }

    public function testIsHanukkahDay7()
    {
        $tarich = Tarich::fromJewish(4, 1, 5778);

        $this->assertTrue($tarich->isHanukkahDay7());
        $this->assertTrue($tarich->isHanukkahDayAny());
    }

    public function testIsHanukkahDay8()
    {
        $tarich = Tarich::fromJewish(4, 2, 5778);

        $this->assertTrue($tarich->isHanukkahDay8());
        $this->assertTrue($tarich->isHanukkahDayAny());
    }
}