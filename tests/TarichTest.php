<?php


use NRHoffmann\Hillel\Tarich;
use PHPUnit\Framework\TestCase;

class TarichTest extends TestCase
{

    public function testMagicGetOnYear()
    {
        $tarich = Tarich::create(9, 3, 5776);
        $this->assertEquals(5776, $tarich->year);
    }

    public function testMagicGetOnMonth()
    {
        $tarich = Tarich::create(9, 3, 5776);
        $this->assertEquals(9, $tarich->month);
    }

    public function testMagicGetOnDay()
    {
        $tarich = Tarich::create(9, 3, 5776);
        $this->assertEquals(3, $tarich->day);
    }

    public function testToString()
    {
        $tarich = Tarich::create(7, 14, 5774);
        $this->assertEquals('7-14-5774', strval($tarich));
    }

    public function testParse()
    {
        $tarich = Tarich::parse("7/14/5774");

        $this->assertEquals(7, $tarich->month);
        $this->assertEquals(14, $tarich->day);
        $this->assertEquals(5774, $tarich->year);
    }

    public function testParseWithCustomFormat()
    {
        $tarich = Tarich::parse("14/5774/7", ['day', 'year', 'month']);

        $this->assertEquals(7, $tarich->month);
        $this->assertEquals(14, $tarich->day);
        $this->assertEquals(5774, $tarich->year);
    }

    public function testCreateGorgarian()
    {
        $tarich = Tarich::createGorgarian(3, 29, 2018);

        $this->assertEquals(8, $tarich->month);
        $this->assertEquals(13, $tarich->day);
        $this->assertEquals(5778, $tarich->year);
    }

    public function testIsSunday()
    {
        $tarich = $tarich = Tarich::createGorgarian(3, 25, 2018);

        $this->assertTrue($tarich->isSunday());
    }

    public function testIsMonday()
    {
        $tarich = $tarich = Tarich::createGorgarian(3, 26, 2018);

        $this->assertTrue($tarich->isMonday());
    }

    public function testIsTuesday()
    {
        $tarich = $tarich = Tarich::createGorgarian(3, 27, 2018);

        $this->assertTrue($tarich->isTuesday());
    }

    public function testIsWednesday()
    {
        $tarich = $tarich = Tarich::createGorgarian(3, 28, 2018);

        $this->assertTrue($tarich->isWednesday());
    }

    public function testIsThursday()
    {
        $tarich = $tarich = Tarich::createGorgarian(3, 29, 2018);

        $this->assertTrue($tarich->isThursday());
    }

    public function testIsFriday()
    {
        $tarich = $tarich = Tarich::createGorgarian(3, 30, 2018);

        $this->assertTrue($tarich->isFriday());
    }

    public function testIsSaturday()
    {
        $tarich = $tarich = Tarich::createGorgarian(3, 31, 2018);

        $this->assertTrue($tarich->isSaturday());
    }
}
