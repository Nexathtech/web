<?php

namespace kodi\common\enums\setting;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `Type`
 * ============
 *
 * This is a ENUM class that represents supported settings input field types.
 */
class Type extends Enum implements EnumInterface
{
    const INPUT = 'Input';
    const TEXTAREA = 'Textarea';
    const CHECKBOX = 'Checkbox';
    const IMAGE = 'Image';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::INPUT => Yii::t('common', 'Input text'),
            self::TEXTAREA => Yii::t('common', 'Text area'),
            self::CHECKBOX => Yii::t('common', 'Checkbox'),
            self::IMAGE => Yii::t('common', 'Input file'),
        ];
    }
}