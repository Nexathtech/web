<?php

namespace kodi\common\enums\user;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `Type`
 * ============
 *
 * This is a ENUM class that represents supported user roles.
 *
 */
class Type extends Enum implements EnumInterface
{
    const SIMPLE = 'Simple';
    const BRAND = 'Brand';
    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::SIMPLE => Yii::t('common', 'Simple'),
            self::BRAND => Yii::t('common', 'Brand'),
        ];
    }
}
