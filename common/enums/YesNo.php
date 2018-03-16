<?php

namespace kodi\common\enums;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `YesNo`
 * =============
 *
 * This is a ENUM class that represents yes no statement.
 *
 */
class YesNo extends Enum implements EnumInterface
{
    const YES = 1;
    const NO = 0;

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::YES => Yii::t('common', 'Yes'),
            self::NO => Yii::t('common', 'No'),
        ];
    }
}