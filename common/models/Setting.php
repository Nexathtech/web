<?php

namespace kodi\common\models;

use kodi\common\behaviors\TimestampBehavior;
use kodi\common\enums\setting\Bunch;
use kodi\common\enums\setting\Type;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\validators\NumberValidator;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;
use yii\validators\UniqueValidator;

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

            // Unique fields
            [['name'], UniqueValidator::class],

            // Strings validation
            [['title', 'description', 'value'], StringValidator::class],
            [['name', 'bunch'], StringValidator::class, 'max' => 64],

            // Range validation
            [['type'], RangeValidator::class, 'range' => array_keys(Type::listData())],
            //[['bunch'], RangeValidator::class, 'range' => array_keys(Bunch::listData())],

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

    /**
     * Retrieves data from setting by given key(s) name
     *
     * @param $key string|array
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null) {
        $items = self::find()->select(['name', 'value'])->where(['name' => $key])->asArray()->all();
        if (!empty($items)) {
            if (is_array($key)) {
                return ArrayHelper::map($items, 'name', 'value');
            } else {
                return ArrayHelper::getColumn($items, 'value')[0];
            }
        }

        return $default;
    }

    /**
     * Sets setting value by given key
     *
     * @param $key
     * @param $value
     * @param null $title
     * @param null $bunch
     * @param null $type
     * @return bool
     */
    public function set($key, $value, $title = null, $bunch = null, $type = null) {
        $model = self::find()->where(['name' => $key])->one();
        if (empty($model)) {
            $model = new self;
            $model->title = $title ?: $key;
            $model->name = $key;
            $model->bunch = $bunch ?: Bunch::SYSTEM;
            $model->type = $type ?: Type::INPUT;
        }
        $model->value = $value;
        if ($model->save()) {
            return true;
        }
        return false;
    }

}
