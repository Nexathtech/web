<?php

namespace kodi\common\enums\order;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `OrderType`
 * =================
 *
 * This is a ENUM class that represents supported common statuses.
 *
 */
class OrderType extends Enum implements EnumInterface
{
    const KIOSK = 'Kiosk';
    const PHOTO = 'Photo';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::KIOSK => Yii::t('common', 'Kiosk'),
            self::PHOTO => Yii::t('common', 'Photo'),
        ];
    }
}