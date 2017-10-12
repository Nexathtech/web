<?php

namespace kodi\common\enums;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `DeviceType`
 * =================
 *
 * This is an ENUM class that represents supported device types.
 */
class DeviceType extends Enum implements EnumInterface
{
    const MOBILE = 'Mobile';
    const KIOSK = 'Kiosk';
    const BROWSER = 'Browser';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::MOBILE => Yii::t('common', 'Mobile'),
            self::KIOSK => Yii::t('common', 'Kiosk'),
            self::BROWSER => Yii::t('common', 'Browser'),
        ];
    }
}