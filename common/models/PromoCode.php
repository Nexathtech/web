<?php

namespace kodi\common\models;

use Carbon\Carbon;
use kodi\common\behaviors\TimestampBehavior;
use kodi\common\enums\PromoCodeStatus;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

/**
 * Class `PromoCode`
 * =================
 *
 * This is the model class for table "{{%promo_code}}".
 *
 *
 * Available table columns:
 * ------------------------
 *
 * @property integer $id
 * @property integer $code
 * @property string $identity_id
 * @property string $description
 * @property string $status
 * @property string $created_at
 * @property string $expires_at
 *
 *
 * Available AR relations:
 * -----------------------
 *
 * @property SocialUser $identity
 */
class PromoCode extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%promo_code}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [

            // Required fields
            [['code'], RequiredValidator::class],

            // Strings validation
            [['identity_id', 'description'], StringValidator::class, 'max' => 255],
            [['expires_at'], StringValidator::class, 'max' => 64],

            // Range validation
            ['status', RangeValidator::class, 'range' => array_keys(PromoCodeStatus::listData())],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'code' => Yii::t('common', 'Promo Code'),
            'identity_id' => Yii::t('common', 'Identity Id'),
            'description' => Yii::t('common', 'Description'),
            'created_at' => Yii::t('common', 'Created At'),
            'expires_at' => Yii::t('common', 'Expires At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'setTimestamps' => [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert): bool
    {
        // Set auto-generated fields
        if ($insert) {
            if (empty($this->expires_at)) {
                $this->expires_at = Carbon::now()->addDay(1)->toDateTimeString();
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * Returns social user profile.
     *
     * @return ActiveQuery
     */
    public function getIdentity()
    {
        return $this->hasOne(SocialUser::class, ['uuid' => 'identity_id']);
    }

    /**
     * Returns random digit code with specified length
     *
     * @param int $length
     * @return int
     */
    public static function generateRandomCode($length = 5) {
        return rand(pow(10, $length-1), pow(10, $length)-1);
    }

}
