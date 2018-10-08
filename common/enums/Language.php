<?php

namespace kodi\common\enums;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `Language`
 * ================
 *
 * This is a ENUM class that represents website language.
 *
 */
class Language extends Enum implements EnumInterface
{
    const ENGLISH = 'en';
    const ITALIAN = 'it';
    const PORTUGUESE = 'pt';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::ENGLISH => Yii::t('common', 'English'),
            self::ITALIAN => Yii::t('common', 'Italian'),
            self::PORTUGUESE => Yii::t('common', 'Portuguese'),
        ];
    }
}