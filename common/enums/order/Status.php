<?php

namespace kodi\common\enums\order;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `Status`
 * ==============
 *
 * This is a ENUM class that represents supported common statuses.
 *
 */
class Status extends Enum implements EnumInterface
{
    const WAITING = 'Waiting';
    const PENDING = 'Pending';
    const REVIEWED = 'Reviewed';
    const SHIPPED = 'Shipped';
    const COMPLETED = 'Completed';
    const CANCELED = 'Canceled';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::WAITING => Yii::t('common', 'Waiting for payment'),
            self::PENDING => Yii::t('common', 'Pending'),
            self::REVIEWED => Yii::t('common', 'Reviewed'),
            self::SHIPPED => Yii::t('common', 'Shipped'),
            self::COMPLETED => Yii::t('common', 'Completed'),
            self::CANCELED => Yii::t('common', 'Canceled'),
        ];
    }
}
