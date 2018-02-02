<?php

namespace kodi\common\enums\order;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `PaymentType`
 * ===================
 *
 * This is a ENUM class that represents supported common statuses.
 *
 */
class PaymentType extends Enum implements EnumInterface
{
    const BITCOIN = 'Bitcoin';
    const WIRETRANSFER = 'Wire Transfer';
    const NONE = 'None';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::BITCOIN => Yii::t('common', 'Bitcoin'),
            self::WIRETRANSFER => Yii::t('common', 'Wire Transfer'),
            self::NONE => Yii::t('common', 'None'),
        ];
    }
}