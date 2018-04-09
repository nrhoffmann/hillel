<?php

namespace NRHoffmann\Hillel\Traits;

use ReflectionClass;

trait EnumerableConstants
{
    /**
     * @param $value
     *
     * @throws \ReflectionException
     *
     * @return mixed
     */
    final public static function getNameOf($value)
    {
        $class = new ReflectionClass(self::class);
        $constants = $class->getConstants();
        $constants = array_flip($constants);

        return $constants[$value];
    }
}
