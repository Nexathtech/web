<?php

namespace kodi\common\enums;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `AlertType`
 * =================
 *
 * This is a ENUM class that represents supported alert types.
 *
 *
 * @method static AlertType INFO()
 * @method static AlertType SUCCESS()
 * @method static AlertType WARNING()
 * @method static AlertType ERROR()
 */
class AlertType extends Enum implements EnumInterface
{
    const INFO = 'info';
    const SUCCESS = 'success';
    const WARNING = 'warning';
    const ERROR = 'error';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::INFO => Yii::t('fae/common', 'Info'),
            self::SUCCESS => Yii::t('fae/common', 'Success'),
            self::WARNING => Yii::t('fae/common', 'Warning'),
            self::ERROR => Yii::t('fae/common', 'Error'),
        ];
    }
}