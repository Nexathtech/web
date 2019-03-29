<?php

namespace kodi\common\models\event;

use kodi\common\behaviors\TimestampBehavior;
use kodi\common\enums\Status;
use Yii;
use yii\db\ActiveRecord;
use yii\validators\NumberValidator;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

/**
 * Class `Event`
 * =============
 *
 * This is the model class for table "{{%event}}".
 * It represents information about event.
 *
 * Available table columns:
 * ------------------------
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $logo
 * @property float $location_latitude
 * @property float $location_longitude
 * @property integer $location_radius
 * @property integer $users_max_prints_amount
 * @property string $starts_at
 * @property string $ends_at
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 */
class Event extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%event}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [

            // Required fields
            [['title', 'location_latitude', 'location_longitude', 'location_radius'], RequiredValidator::class],

            // Strings validation
            [['description', 'starts_at', 'ends_at'], StringValidator::class],
            [['logo'], StringValidator::class, 'max' => 255],
            [['location_latitude', 'location_longitude'], StringValidator::class, 'max' => 64],

            // Range validation
            ['status', RangeValidator::class, 'range' => array_keys(Status::listData())],

            // Numbers validation
            [['location_radius', 'users_max_prints_amount'], NumberValidator::class, 'integerOnly' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'title' => Yii::t('common', 'Name'),
            'description' => Yii::t('common', 'Description'),
            'logo' => Yii::t('common', 'Logo'),
            'location_latitude' => Yii::t('common', 'Latitude'),
            'location_longitude' => Yii::t('common', 'Longitude'),
            'location_radius' => Yii::t('common', 'Radius, m'),
            'users_max_prints_amount' => Yii::t('common', 'Max prints allowed'),
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
        if (empty($this->logo)) {
            $this->logo = null;
        }

        return parent::beforeSave($insert);
    }

}
