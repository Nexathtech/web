<?php

namespace kodi\common\enums\setting;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `Bunch`
 * ============
 *
 * This is a ENUM class that represents supported settings bunch types.
 */
class Bunch extends Enum implements EnumInterface
{
    const COMPONENTS = 'Components';
    const DEVICES = 'Devices';
    const SYSTEM = 'System';
    const OTHER = 'Other';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::COMPONENTS => Yii::t('common', 'Components'),
            self::DEVICES => Yii::t('common', 'Devices'),
            self::SYSTEM => Yii::t('common', 'System'),
            self::OTHER => Yii::t('common', 'Other'),
        ];
    }
}