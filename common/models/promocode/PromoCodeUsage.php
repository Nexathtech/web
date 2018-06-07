<?php

namespace kodi\common\models\promocode;

use Carbon\Carbon;
use kodi\common\behaviors\TimestampBehavior;
use kodi\common\enums\promocode\Status;
use kodi\common\enums\promocode\Type;
use kodi\common\models\Action;
use kodi\common\models\SocialUser;
use kodi\common\models\user\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\SafeValidator;
use yii\validators\StringValidator;

/**
 * Class `PromoCodeUsage`
 * ======================
 *
 * This is the model class for table "{{%promo_code_usage}}".
 *
 *
 * Available table columns:
 * ------------------------
 * @property integer $id
 * @property integer $user_id
 * @property integer $code_id
 * @property string $created_at
 *
 *
 * Available AR relations:
 * -----------------------
 * @property User $user
 * @property PromoCode $promoCode
 *
 */
class PromoCodeUsage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%promo_code_usage}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            // Required fields
            [['code_id'], RequiredValidator::class],

            // Safe validation
            [['user_id'], SafeValidator::class],
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
     * Returns user.
     *
     * @return ActiveQuery|null
     */
    public function getUser()
    {
        if (!empty($this->user_id)) {
            return $this->hasOne(User::class, ['id' => 'user_id']);
        }

        return null;
    }

    /**
     * Returns a promo code.
     *
     * @return ActiveQuery|null
     */
    public function getPromoCode()
    {
        return $this->hasOne(PromoCode::class, ['id' => 'code_id']);
    }

}
