<?php


use NRHoffmann\Hillel\Tarich;
use PHPUnit\Framework\TestCase;

class TarichTest extends TestCase
{

    public function testIsLeapYear()
    {
        $tarich = Tarich::create(1,1, 5774);
        $this->assertTrue($tarich->isLeapYear());

        $tarich = Tarich::create(1,1, 5775);
        $this->assertFalse($tarich->isLeapYear());
    }

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
}
