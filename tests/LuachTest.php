<?php


use NRHoffmann\Hillel\Luach;
use PHPUnit\Framework\TestCase;

class LuachTest extends TestCase
{
    public function testIsLeapYear()
    {
        $this->assertTrue(Luach::isLeapYear(5774));
        $this->assertFalse(Luach::isLeapYear(5775));
    }
}
