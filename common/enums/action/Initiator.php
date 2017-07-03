<?php

namespace kodi\common\enums\user;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `Initiator`
 * =================
 *
 * This is a ENUM class that represents supported actions' types.
 *
 *
 * @method static Initiator DEVICE()
 * @method static Initiator MOBILE_APP()
 * @method static Initiator USER()
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
            self::DEVICE => Yii::t('kodi/common', 'Kiosk Device'),
            self::MOBILE_APP => Yii::t('kodi/common', 'Mobile app'),
            self::USER => Yii::t('kodi/common', 'User'),
        ];
    }
}