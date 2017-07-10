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
 * @method static Status INACTIVE()
 * @method static Status ACTIVE()
 * @method static Status SUSPENDED()
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
            self::INACTIVE => Yii::t('common', 'Not Active'),
            self::ACTIVE => Yii::t('common', 'Active'),
            self::SUSPENDED => Yii::t('common', 'Suspended'),
        ];
    }
}