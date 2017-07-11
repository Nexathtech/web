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
    const FEEDBACK = 'Feedback';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::PRINT => Yii::t('common', 'Print'),
            self::FEEDBACK => Yii::t('common', 'Feedback'),
        ];
    }
}