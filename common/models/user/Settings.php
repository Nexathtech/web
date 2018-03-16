<?php

namespace kodi\common\models\user;

use kodi\common\enums\Language;
use kodi\common\enums\setting\Type;
use kodi\common\enums\YesNo;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\validators\ExistValidator;
use yii\validators\NumberValidator;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;
use yii\validators\UniqueValidator;

/**
 * Class `Settings`
 * ================
 *
 * This is the model class for table "{{%user_settings}}".
 *
 *
 * Available table columns:
 * ------------------------
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $key
 * @property string $value
 * @property string $type
 * @property string $options
 * @property integer $writable
 *
 * Available AR relations:
 * -----------------------
 *
 * @property User $user
 *
 */
class Settings extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%user_settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [

            // Required fields
            [['user_id', 'title', 'key', 'type'], RequiredValidator::class],

            // Unique fields
            [['key'], UniqueValidator::class],

            // Strings validation
            [['title', 'key'], StringValidator::class, 'max' => 64],
            [['value', 'options'], StringValidator::class],

            // Range validation
            [['type'], RangeValidator::class, 'range' => array_keys(Type::listData())],
            [['writable'], RangeValidator::class, 'range' => array_keys(YesNo::listData())],

            // Numbers validation
            [['user_id'], NumberValidator::class, 'integerOnly' => true],

            // Existence validation
            [['user_id'], ExistValidator::class, 'targetClass' => User::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * Returns related user.
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])
            ->inverseOf('settings');
    }

    /**
     * Settings fields that are currently available for each user
     *
     * @return array
     */
    public static function defaultFields()
    {
        return [
            [
                'title' => 'Language',
                'key' => 'users_language',
                'value' => Language::ENGLISH,
                'type' => Type::SELECT,
                'options' => Json::encode(Language::listData()),
                'writable' => 1,
            ],
            [
                'title' => 'Max prints amount',
                'key' => 'users_max_prints_amount',
                'value' => null,
                'type' => Type::INPUT,
                'writable' => 0,
            ],
        ];
    }

}
