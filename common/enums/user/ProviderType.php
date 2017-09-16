<?php

namespace kodi\common\enums\user;

use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;

/**
 * Class `ProviderType`
 * ====================
 *
 * This is an ENUM class that represents user's auth provider types.
 *
 */
class ProviderType extends Enum implements EnumInterface
{
    const GOOGLE = 'Google';
    const FACEBOOK = 'Facebook';

    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::GOOGLE => Yii::t('common', 'Google'),
            self::FACEBOOK => Yii::t('common', 'Facebook'),
        ];
    }
}