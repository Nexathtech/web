<?php

namespace kodi\common\enums\promocode;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `Type`
 * ============
 *
 * This is a ENUM class that represents supported promo code types.
 */
class Type extends Enum implements EnumInterface
{
    const REGULAR = 'Regular';
    const EXTENDED = 'Extended';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::REGULAR => Yii::t('common', 'Regular'),
            self::EXTENDED => Yii::t('common', 'Extended'),
        ];
    }
}