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
    const TRANSFERWISE = 'TransferWise';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::BITCOIN => Yii::t('common', 'Bitcoin'),
            self::TRANSFERWISE => Yii::t('common', 'Transfer Wise'),
        ];
    }
}