<?php

namespace kodi\common\models\user;

use kodi\common\behaviors\TimestampBehavior;
use kodi\common\enums\user\TokenType;
use kodi\common\models\device\Device;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\validators\ExistValidator;
use yii\validators\NumberValidator;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

/**
 * Class `AuthToken`
 * =================
 *
 * This is the model class for table "{{%user_auth_token}}".
 *
 *
 * Available table columns:
 * ------------------------
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $device_id
 * @property string $token
 * @property string $token_refresh
 * @property string $type
 * @property string $created_at
 * @property string $expires_at
 *
 * Available AR relations:
 * -----------------------
 *
 * @property User $user
 * @property Device $device
 *
 *
 * @see AuthProviderQuery
 */
class AuthToken extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%user_auth_token}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User ID'),
            'device_id' => Yii::t('common', 'Device ID'),
            'token' => Yii::t('common', 'Token'),
            'token_refresh' => Yii::t('common', 'Refresh Token'),
            'type' => Yii::t('common', 'Token Type'),
            'created_at' => Yii::t('common', 'Created At'),
            'expires_at' => Yii::t('common', 'Expires At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [

            // Required fields
            [['user_id', 'token', 'type'], RequiredValidator::class],

            // Strings validation
            [['token'], StringValidator::class],
            [['type'], RangeValidator::class, 'range' => array_keys(TokenType::listData())],

            // Numbers validation
            [['user_id', 'device_id'], NumberValidator::class, 'integerOnly' => true],

            // Existence validation
            [['user_id'], ExistValidator::class, 'targetClass' => User::class, 'targetAttribute' => 'id'],
            [['device_id'], ExistValidator::class, 'targetClass' => Device::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'setTimestamps' => [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ]);
    }

    /**
     * Returns related user.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Returns related device.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDevice()
    {
        return $this->hasOne(Device::class, ['id' => 'device_id']);
    }
}
