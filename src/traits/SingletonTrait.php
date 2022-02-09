<?php

namespace Blok\Utils\Traits;

trait SingletonTrait
{
    private static $_instance = array();

    /**
     * Retrieve the current instance
     *
     * @return mixed
     */
    public static function getInstance()
    {

        $sClass = static::class;

        if (!isset(self::$_instance[$sClass])) {
            self::$_instance[$sClass] = new $sClass;
        }

        return self::$_instance[$sClass];
    }
}
