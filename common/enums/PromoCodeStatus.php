<?php

namespace kodi\common\enums;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `PromoCodeStatus`
 * =======================
 *
 * This is a ENUM class that represents supported promo code statuses.
 */
class PromoCodeStatus extends Enum implements EnumInterface
{
    const NEW = 'New';
    const USED = 'Used';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::NEW => Yii::t('common', 'New'),
            self::USED => Yii::t('common', 'Used'),
        ];
    }
}