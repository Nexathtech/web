<?php

namespace kodi\common\models;

use Carbon\Carbon;
use kodi\common\behaviors\TimestampBehavior;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
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
 */
class PromoCode extends ActiveRecord
{
    /**
     * @var string
     */
    const STATUS_NEW = 'New';

    /**
     * @var string
     */
    const STATUS_USED = 'Used';

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
            ['status', RangeValidator::class, 'range' => [self::STATUS_NEW, self::STATUS_USED]],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('kodi/common', 'ID'),
            'code' => Yii::t('kodi/common', 'Promo Code'),
            'identity_id' => Yii::t('kodi/common', 'Identity Id'),
            'description' => Yii::t('kodi/common', 'Description'),
            'created_at' => Yii::t('kodi/common', 'Created At'),
            'expires_at' => Yii::t('kodi/common', 'Expires At'),
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
     * Returns random digit code with specified length
     *
     * @param int $length
     * @return int
     */
    public static function generateRandomCode($length = 5) {
        return rand(pow(10, $length-1), pow(10, $length)-1);
    }

}
