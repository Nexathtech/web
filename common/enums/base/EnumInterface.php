<?php

namespace kodi\common\enums\base;

/**
 * Interface `EnumInterface`
 * =========================
 *
 * This interface is introducing additional method for gathering enum list data.
 */
interface EnumInterface
{
    /**
     * Returns enum list data.
     *
     * @return array
     */
    public static function listData(): array;
}