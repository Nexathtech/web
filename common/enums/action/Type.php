<?php

namespace kodi\common\enums\user;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `Type`
 * ============
 *
 * This is a ENUM class that represents supported actions' types.
 *
 *
 * @method static Type PRINT()
 */
class Type extends Enum implements EnumInterface
{
    const PRINT = 'Print';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::PRINT => Yii::t('kodi/common', 'Print'),
        ];
    }
}