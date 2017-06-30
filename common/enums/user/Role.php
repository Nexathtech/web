<?php

namespace kodi\common\enums\user;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `Role`
 * ============
 *
 * This is a ENUM class that represents supported user roles.
 *
 *
 * @method static Role ADMINISTRATOR()
 * @method static Role CUSTOMER()
 */
class Role extends Enum implements EnumInterface
{
    const ADMINISTRATOR = 'Administrator';
    const CUSTOMER = 'Customer';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::ADMINISTRATOR => Yii::t('kodi/common', 'Administrator'),
            self::CUSTOMER => Yii::t('kodi/common', 'Customer'),
        ];
    }
}