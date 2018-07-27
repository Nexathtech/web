<?php

namespace kodi\common\enums;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `AccessLevel`
 * ===================
 *
 * This is a ENUM class that represents supported access levels.
 *
 */
class AccessLevel extends Enum implements EnumInterface
{
    const EVERYONE = 0;
    const CUSTOMER = 10;
    const CUSTOMER_KIOSK = 50;
    const ADMIN = 100;

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::EVERYONE => Yii::t('common', 'For everyone'),
            self::CUSTOMER => Yii::t('common', 'For customers'),
            self::CUSTOMER_KIOSK => Yii::t('common', 'For KIOSK customers'),
            self::ADMIN => Yii::t('common', 'For admins'),
        ];
    }
}