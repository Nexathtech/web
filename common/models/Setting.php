<?php

namespace kodi\common\models;

use kodi\common\behaviors\TimestampBehavior;
use kodi\common\enums\setting\Type;
use yii\db\ActiveRecord;
use yii\validators\NumberValidator;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

/**
 * Class `Setting`
 * ===============
 *
 * This is the model class for table "{{%setting}}".
 *
 *
 * Available table columns:
 * ------------------------
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $name
 * @property string $value
 * @property string $bunch
 * @property string $type
 * @property integer $sort_order
 * @property string $updated_at
 *
 */
class Setting extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%setting}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [

            // Required fields
            [['title', 'name', 'bunch', 'type'], RequiredValidator::class],

            // Strings validation
            [['title', 'description', 'value'], StringValidator::class],
            [['name', 'bunch'], StringValidator::class, 'max' => 64],

            // Range validation
            [['type'], RangeValidator::class, 'range' => array_keys(Type::listData())],

            // Integer validation
            [['sort_order'], NumberValidator::class],

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
                'createdAtAttribute' => false,
            ],
        ];
    }

}
