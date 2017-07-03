<?php

namespace kodi\common\models;

use kodi\common\behaviors\TimestampBehavior;
use Yii;
use yii\db\ActiveRecord;
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
            'id' => Yii::t('kodi/common', 'ID'),
            'initiator' => Yii::t('kodi/common', 'Initiator'),
            'initiator_id' => Yii::t('kodi/common', 'Initiator Id'),
            'type' => Yii::t('kodi/common', 'Type'),
            'data' => Yii::t('kodi/common', 'Data'),
            'promo_code' => Yii::t('kodi/common', 'Promo Code'),
            'created_at' => Yii::t('kodi/common', 'Created At'),
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
