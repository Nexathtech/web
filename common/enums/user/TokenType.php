<?php
namespace kodi\common\enums\user;
use kodi\common\enums\base\Enum;
use kodi\common\enums\base\EnumInterface;
use Yii;
/**
 * Class `TokenType`
 * =================
 *
 * This is an ENUM class that represents user's token types.
 *
 */
class TokenType extends Enum implements EnumInterface
{
    const UNSUBSCRIBE = 'Unsubscribe';
    const PASSWORD_RESET = 'Password reset';
    const EMAIL_CONFIRMATION = 'Email confirmation';
    const ACCESS = 'Access';
    const EXTERNAL_LOGIN = 'External login';
    /**
     * @inheritdoc
     */
    public static function listData(): array
    {
        return [
            self::UNSUBSCRIBE => Yii::t('common', 'Unsubscribe'),
            self::PASSWORD_RESET => Yii::t('common', 'Password reset'),
            self::EMAIL_CONFIRMATION => Yii::t('common', 'Email confirmation'),
            self::ACCESS => Yii::t('common', 'Access'),
            self::EXTERNAL_LOGIN => Yii::t('common', 'External login'),
        ];
    }
}
