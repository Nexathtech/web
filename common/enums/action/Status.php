<?php

namespace kodi\common\enums\action;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `Status`
 * ==============
 *
 * This is a ENUM class that represents supported actions' statuses.
 */
class Status extends Enum implements EnumInterface
{
    const NEW = 'New';
    const ARCHIVED = 'Archived';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::NEW => Yii::t('common', 'New'),
            self::ARCHIVED => Yii::t('common', 'Archived'),
        ];
    }
}