<?php

namespace kodi\common\enums\action;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `Initiator`
 * =================
 *
 * This is a ENUM class that represents supported actions' types.
 */
class Initiator extends Enum implements EnumInterface
{
    const DEVICE = 'Device';
    const MOBILE_APP = 'Mobile';
    const USER = 'User';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::DEVICE => Yii::t('common', 'Kiosk Device'),
            self::MOBILE_APP => Yii::t('common', 'Mobile app'),
            self::USER => Yii::t('common', 'User'),
        ];
    }
}