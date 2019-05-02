<?php

namespace kodi\common\models;

use kodi\common\behaviors\TimestampBehavior;
use kodi\common\enums\action\Status;
use kodi\common\enums\action\Type;
use kodi\common\enums\DeviceType;
use kodi\common\models\device\Device;
use kodi\common\models\event\Event;
use kodi\common\models\user\User;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\validators\ExistValidator;
use yii\validators\NumberValidator;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

/**
 * Class `Action`
 * ==============
 *
 * This is the model class for table "{{%action}}".
 *
 *
 * Available table columns:
 * ------------------------
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $device_id
 * @property integer $event_id
 * @property string $action_type
 * @property string $device_type
 * @property string $data
 * @property string $promo_code
 * @property string $status
 * @property string $created_at
 *
 *
 * Available AR relations:
 * -----------------------
 * @property User $user
 * @property Device $device
 * @property Event $event
 */
class Action extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%action}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [

            // Required fields
            [['device_type', 'action_type', 'user_id'], RequiredValidator::class],

            // Strings validation
            [['data'], StringValidator::class],
            [['promo_code'], StringValidator::class, 'max' => 64],
            ['action_type', RangeValidator::class, 'range' => array_keys(Type::listData())],
            ['device_type', RangeValidator::class, 'range' => array_keys(DeviceType::listData())],
            ['status', RangeValidator::class, 'range' => array_keys(Status::listData())],

            // Numbers validation
            [['user_id', 'device_id', 'event_id'], NumberValidator::class, 'integerOnly' => true],

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
            'user_id' => Yii::t('common', 'User Id'),
            'device_id' => Yii::t('common', 'Device Id'),
            'action_type' => Yii::t('common', 'Action type'),
            'device_type' => Yii::t('common', 'Device type'),
            'data' => Yii::t('common', 'Data'),
            'promo_code' => Yii::t('common', 'Promo Code'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
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
     * Returns related user.
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Returns related device (if set).
     */
    public function getDevice()
    {
        return $this->hasOne(Device::class, ['id' => 'device_id']);
    }

    /**
     * Returns related event (if set).
     */
    public function getEvent()
    {
        return $this->hasOne(Event::class, ['id' => 'event_id']);
    }

    /**
     * Returns amount with new actions with further shipment
     * @return int|string
     */
    public static function getPrintShipmentAmount()
    {
        return self::find()->where([
            'action_type' => Type::PRINT_SHIPMENT,
            'status' => Status::NEW,
        ])->count();
    }

    /**
     * @param $userId
     * @param int $interval months
     * @param null $eventId
     * @return array|ActiveRecord[]
     */
    public static function getUserRecentPrints($userId, $interval = 1, $eventId = null)
    {
        $query = Action::find()->where([
            'action_type' => Type::PRINT_SHIPMENT,
            'user_id' => $userId,
        ])
            ->andWhere(['>=', 'created_at', new Expression("NOW() - INTERVAL {$interval} MONTH")]);
        if ($eventId) {
            $query->andWhere(['event_id' => $eventId]);
        }

        return $query->all();
    }

    /**
     * @param $userId
     * @param int $interval
     * @return int|string
     */
    public static function getUserRecentPrintsAmount($userId, $interval = 1)
    {
        return AdImage::find()->where(['user_id' => $userId])->andWhere([
            '>=', 'created_at', new Expression("NOW() - INTERVAL {$interval} MONTH")
        ])->count();
    }

}
