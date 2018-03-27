<?php


use Nrhoffmann\Tarich\Tarich;
use PHPUnit\Framework\TestCase;

class TarichTest extends TestCase
{

    public function testIsLeapYear()
    {
        $this->assertTrue(Tarich::isLeapYear(1927));
    }
}
