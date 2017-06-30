<?php

namespace kodi\common\enums\user;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `Status`
 * =============
 *
 * This is a ENUM class that represents supported users' statuses.
 *
 *
 * @method static Role INACTIVE()
 * @method static Role ACTIVE()
 * @method static Role SUSPENDED()
 */
class Status extends Enum implements EnumInterface
{
    const INACTIVE = 'Inactive';
    const ACTIVE = 'Active';
    const SUSPENDED = 'Suspended';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::INACTIVE => Yii::t('kodi/common', 'Not Active'),
            self::ACTIVE => Yii::t('kodi/common', 'Active'),
            self::SUSPENDED => Yii::t('kodi/common', 'Suspended'),
        ];
    }
}