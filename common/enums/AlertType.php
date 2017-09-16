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
            self::INFO => Yii::t('common', 'Info'),
            self::SUCCESS => Yii::t('common', 'Success'),
            self::WARNING => Yii::t('common', 'Warning'),
            self::ERROR => Yii::t('common', 'Error'),
        ];
    }
}