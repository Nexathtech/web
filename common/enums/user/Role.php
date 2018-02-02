<?php
namespace kodi\common\enums\user;
use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;
/**
 * Class `Role`
 * ============
 *
 * This is a ENUM class that represents supported user roles.
 *
 */
class Role extends Enum implements EnumInterface
{
    const ADMINISTRATOR = 'Administrator';
    const CUSTOMER = 'Customer';
    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::ADMINISTRATOR => Yii::t('common', 'Administrator'),
            self::CUSTOMER => Yii::t('common', 'Customer'),
        ];
    }
}
