<?php

namespace kodi\common\models;

use kodi\common\behaviors\TimestampBehavior;
use kodi\common\enums\action\Status;
use kodi\common\enums\action\Type;
use kodi\common\enums\DeviceType;
use kodi\common\models\user\User;
use Yii;
use yii\db\ActiveRecord;
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
 * @property string $type
 * @property string $agent
 * @property string $data
 * @property string $promo_code
 * @property string $status
 * @property string $created_at
 *
 *
 * Available AR relations:
 * -----------------------
 * @property User $user
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
            [['agent', 'type', 'user_id'], RequiredValidator::class],

            // Strings validation
            [['data'], StringValidator::class],
            [['promo_code'], StringValidator::class, 'max' => 64],
            ['type', RangeValidator::class, 'range' => array_keys(Type::listData())],
            ['agent', RangeValidator::class, 'range' => array_keys(DeviceType::listData())],
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
            'user_id' => Yii::t('common', 'Initiator Id'),
            'type' => Yii::t('common', 'Type'),
            'agent' => Yii::t('common', 'Device type'),
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

}
