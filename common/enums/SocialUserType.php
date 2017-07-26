<?php

namespace kodi\common\enums;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `SocialUserType`
 * ======================
 *
 * This is a ENUM class that represents supported social user types.
 *
 */
class SocialUserType extends Enum implements EnumInterface
{
    const FACEBOOK = 'Facebook';
    const INSTAGRAM = 'Instagram';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::FACEBOOK => Yii::t('fae/common', 'Facebook'),
            self::INSTAGRAM => Yii::t('fae/common', 'Instagram'),
        ];
    }
}