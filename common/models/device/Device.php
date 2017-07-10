<?php

namespace kodi\common\models\device;

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
 * Class `Device`
 * ==============
 *
 * This is the model class for table "{{%device}}".
 *
 *
 * Available table columns:
 * ------------------------
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $photo
 * @property string $status
 * @property string $access_token
 * @property string $location_latitude
 * @property string $location_longitude
 * @property integer $created_at
 * @property integer $updated_at
 *
 * Available AR relations:
 * -----------------------
 *
 * @property User $user
 *
 */
class Device extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%device}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [

            // Required fields
            [['user_id'], RequiredValidator::class],

            // Strings validation
            [['photo'], StringValidator::class, 'max' => 255],
            [['name', 'access_token', 'location_latitude', 'location_longitude'], StringValidator::class, 'max' => 64],

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
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'Owner ID'),
            'name' => Yii::t('common', 'Name'),
            'photo' => Yii::t('common', 'Photo'),
            'location_latitude' => Yii::t('common', 'Latitude'),
            'location_longitude' => Yii::t('common', 'Longitude'),
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
    public function beforeSave($insert): bool
    {
        // Set auto-generated fields
        if (empty($this->access_token)) {
            $security = Yii::$app->getSecurity();
            $this->setAttributes([
                'access_token' => $security->generateRandomString(64),
            ], false);
        }
        if (empty($this->photo)) {
            $this->photo = null;
        }

        return parent::beforeSave($insert);
    }

    /**
     * Returns identity by it's access token
     *
     * @param $token
     * @param null $type
     * @return static
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Returns related user.
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        if (!empty($this->photo)) {
            return $this->photo;
        }

        return '/img/no-photo-android.png';
    }

}
