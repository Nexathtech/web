<?php

namespace kodi\common\models\promocode;

use Carbon\Carbon;
use kodi\common\behaviors\TimestampBehavior;
use kodi\common\enums\promocode\Status;
use kodi\common\enums\promocode\Type;
use kodi\common\models\Action;
use kodi\common\models\SocialUser;
use kodi\common\models\user\Settings;
use Yii;
use yii\base\ErrorException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;
use yii\web\ForbiddenHttpException;

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
 * @property string $type
 * @property string $data
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
            [['data'], StringValidator::class],

            // Range validation
            ['status', RangeValidator::class, 'range' => array_keys(Status::listData())],
            ['type', RangeValidator::class, 'range' => array_keys(Type::listData())],

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
     * Checks if the coupon code is valid
     *
     * @param null $forUserId
     * @return bool
     * @throws ForbiddenHttpException
     */
    public function isValid($forUserId = null)
    {
        // Used or expired coupons are invalid
        if ($this->status === Status::USED || $this->expires_at < Carbon::now()->toDateTimeString()) {
            throw new ForbiddenHttpException(Yii::t('frontend', 'This promo code is invalid.'));
        }

        // One user can use maximum 3 unique coupons per month
        if (!$forUserId && !Yii::$app->user->isGuest) {
            $forUserId = Yii::$app->user->id;
        }
        if ($forUserId) {
            // Find used promo codes of the user
            $usedPromoCodes = PromoCodeUsage::findAll(['user_id' => $forUserId]);
            $usedThisMonth = 0;

            foreach ($usedPromoCodes as $code) {
                if ($code->code_id === $this->id) {
                    throw new ForbiddenHttpException(Yii::t('frontend', 'You have already used this promo code.'));
                }
                if ($code->created_at > Carbon::now()->subDays(30)->toDateTimeString()) {
                    $usedThisMonth++;
                }
            }

            if ($usedThisMonth >= 3) {
                throw new ForbiddenHttpException(Yii::t('frontend', 'You have already used max. amount of promo codes this month.'));
            }
        }

        return true;
    }

    /**
     * Marks the coupon code as used
     */
    public function use()
    {
        // Only extended coupons might be used multiple times
        if ($this->type === Type::EXTENDED) {
            if (!empty($this->data)) {
                $data = Json::decode($this->data);
                if (!empty($data['additional_prints'])) {
                    $userSettings = Settings::findOne(['user_id' => Yii::$app->user->id, 'key' => 'users_max_prints_amount']);
                    if (!empty($userSettings)) {
                        $userSettings->value += $data['additional_prints'];
                        $userSettings->save(false);
                    }
                }
            }
        } else {
            $this->status = Status::USED;
            $this->save(false);
        }

        $promoCodeUsage = new PromoCodeUsage([
            'user_id' => Yii::$app->user->id,
            'code_id' => $this->id,
        ]);
        $promoCodeUsage->save(false);
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
