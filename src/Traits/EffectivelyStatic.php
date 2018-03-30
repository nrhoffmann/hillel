<?php


namespace NRHoffmann\Hillel\Traits;


use AssertionError;

trait EffectivelyStatic
{
    /**
     * private constructor.
     *
     * Makes classes effectively static, thus should never be instantiated.
     * The constructor does nothing more than enforce that, and will throw an
     * error if called internally or using reflection.
     *
     * @throws \AssertionError
     */
    private final function __construct()
    {
        throw new AssertionError('this shouldn\'t be called');
    }
}