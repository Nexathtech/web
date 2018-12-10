<?php

namespace kodi\common\enums\action;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `Type`
 * ============
 *
 * This is a ENUM class that represents supported actions' types.
 */
class Type extends Enum implements EnumInterface
{
    const PRINT = 'Print';
    const PRINT_SHIPMENT = 'PrintShipment';
    const FEEDBACK = 'Feedback';
    const ADD_ADVERTISEMENT = 'AddAdvertisement';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::PRINT => Yii::t('common', 'Print'),
            self::PRINT_SHIPMENT => Yii::t('common', 'Print with shipment'),
            self::FEEDBACK => Yii::t('common', 'Feedback'),
            self::ADD_ADVERTISEMENT => Yii::t('common', 'Add advertisement images'),
        ];
    }
}
