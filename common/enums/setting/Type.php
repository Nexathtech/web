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
    const SELECT = 'Select';
    const TAG = 'Tag';
    const IMAGE = 'Image';
    const PASSWORD = 'Password';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::INPUT => Yii::t('common', 'Input text'),
            self::PASSWORD => Yii::t('common', 'Input password'),
            self::TEXTAREA => Yii::t('common', 'Text area'),
            self::CHECKBOX => Yii::t('common', 'Checkbox'),
            self::SELECT => Yii::t('common', 'Select'),
            self::TAG => Yii::t('common', 'Tag'),
            self::IMAGE => Yii::t('common', 'Input file'),
        ];
    }
}