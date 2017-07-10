<?php

namespace kodi\common\enums;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `Status`
 * =============
 *
 * This is a ENUM class that represents supported common statuses.
 *
 *
 * @method static Status INACTIVE()
 * @method static Status ACTIVE()
 */
class Status extends Enum implements EnumInterface
{
    const INACTIVE = 'Inactive';
    const ACTIVE = 'Active';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::INACTIVE => Yii::t('common', 'Not Active'),
            self::ACTIVE => Yii::t('common', 'Active'),
        ];
    }
}