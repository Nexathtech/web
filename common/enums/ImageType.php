<?php

namespace kodi\common\enums;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `ImageType`
 * =================
 *
 * This is an ENUM class that represents supported image types.
 */
class ImageType extends Enum implements EnumInterface
{
    const ADVERTISEMENT = 'Advertisement';
    const WELCOME = 'Welcome';
    const OTHER = 'Other';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::ADVERTISEMENT => Yii::t('common', 'Advertisement'),
            self::WELCOME => Yii::t('common', 'Welcome'),
            self::OTHER => Yii::t('common', 'Other'),
        ];
    }
}