<?php

namespace kodi\common\models;

use kodi\common\behaviors\TimestampBehavior;
use kodi\common\enums\Status;
use kodi\common\models\user\User;
use Yii;
use yii\db\ActiveRecord;
use yii\validators\ExistValidator;
use yii\validators\NumberValidator;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

/**
 * Class `AdImage`
 * ==============
 *
 * This is the model class for table "{{%ad_image}}".
 *
 * Available table columns:
 * ------------------------
 *
 * @property integer $id
 * @property integer $user_id Id of the user who owns the image
 * @property string $image
 * @property string $status
 * @property string $location_latitude
 * @property string $location_longitude
 * @property string $created_at
 * @property string $updated_at
 *
 * Available AR relations:
 * -----------------------
 *
 * @property User $user
 *
 */
class AdImage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%ad_image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [

            // Required fields
            [['image'], RequiredValidator::class],

            // Strings validation
            [['location_latitude', 'location_longitude'], StringValidator::class, 'max' => 64],

            // Range validation
            ['status', RangeValidator::class, 'range' => array_keys(Status::listData())],

            // Numbers validation
            [['user_id'], NumberValidator::class, 'integerOnly' => true],

            // Existence validation
            [['user_id'], ExistValidator::class, 'targetClass' => User::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (empty($this->user_id)) {
            $this->user_id = Yii::$app->user->getId();
        }

        return parent::beforeValidate();
    }

    /**
     * Returns related user.
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
