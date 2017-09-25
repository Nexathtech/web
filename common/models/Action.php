<?php

namespace kodi\common\models;

use kodi\common\behaviors\TimestampBehavior;
use kodi\common\enums\action\Type;
use kodi\common\enums\Status;
use Yii;
use yii\db\ActiveRecord;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\SafeValidator;
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
 * @property string $initiator
 * @property string $initiator_id
 * @property string $type
 * @property string $data
 * @property string $promo_code
 * @property string $status
 * @property string $created_at
 *
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
            [['initiator', 'type'], RequiredValidator::class],

            // Strings validation
            [['data'], StringValidator::class],
            [['initiator', 'type', 'promo_code'], StringValidator::class, 'max' => 64],
            ['type', RangeValidator::class, 'range' => array_keys(Type::listData())],
            ['status', RangeValidator::class, 'range' => array_keys(Status::listData())],

            // Safe validation
            [['initiator_id'], SafeValidator::class],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'initiator' => Yii::t('common', 'Initiator'),
            'initiator_id' => Yii::t('common', 'Initiator Id'),
            'type' => Yii::t('common', 'Type'),
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

}
