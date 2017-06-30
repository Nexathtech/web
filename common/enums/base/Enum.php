<?php

namespace kodi\common\enums\base;

use MyCLabs\Enum\Enum as BaseEnum;

/**
 * Class Enum.
 *
 * @mixin EnumInterface
 */
abstract class Enum extends BaseEnum
{
    /**
     * Returns label for given enum key.
     *
     * @param string $key Enum key.
     * @return string Enum label.
     */
    public static function getLabel($key): string
    {
        $listData = static::listData();
        return $listData[$key];
    }
}