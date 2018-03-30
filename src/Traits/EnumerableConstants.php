<?php


namespace NRHoffmann\Hillel\Traits;


use ReflectionClass;

trait EnumerableConstants
{
    /**
     * @param $value
     * @return mixed
     * @throws \ReflectionException
     */
    public final static function getNameOf($value)
    {
        $class = new ReflectionClass(self::class);
        $constants = $class->getConstants();
        $constants = array_flip($constants);

        return $constants[$value];
    }
}