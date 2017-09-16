<?php

namespace kodi\common\models\user;

use kodi\common\behaviors\TimestampBehavior;
use kodi\common\enums\user\ProviderType;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\validators\ExistValidator;
use yii\validators\NumberValidator;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

/**
 * Class `AuthProvider`
 * ====================
 *
 * This is the model class for table "{{%user_auth_provider}}".
 *
 *
 * Available table columns:
 * ------------------------
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property string $external_id
 * @property string $external_email
 * @property string $external_image
 * @property string $created_at
 * @property string $updated_at
 *
 * Available AR relations:
 * -----------------------
 *
 * @property User $user
 *
 *
 * @see AuthProviderQuery
 */
class AuthProvider extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%user_auth_provider}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('fae/common', 'ID'),
            'user_id' => Yii::t('fae/common', 'User ID'),
            'type' => Yii::t('fae/common', 'Type'),
            'external_id' => Yii::t('fae/common', 'External ID'),
            'external_email' => Yii::t('fae/common', 'External Email'),
            'external_image' => Yii::t('fae/common', 'External Image'),
            'created_at' => Yii::t('fae/common', 'Created At'),
            'updated_at' => Yii::t('fae/common', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [

            // Required fields
            [['user_id', 'type', 'external_id', 'external_email'], RequiredValidator::class],

            // Strings validation
            [['external_image'], StringValidator::class, 'max' => 255],
            [['external_id', 'external_email'], StringValidator::class, 'max' => 64],
            [['type'], RangeValidator::class, 'range' => array_keys(ProviderType::listData())],

            // Numbers validation
            [['user_id'], NumberValidator::class, 'integerOnly' => true],

            // Existence validation
            [['user_id'], ExistValidator::class, 'targetClass' => User::class, 'targetAttribute' => 'id'],
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
}
