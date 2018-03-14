<?php

namespace kodi\common\models\user;

use Yii;
use yii\db\ActiveRecord;
use yii\validators\ExistValidator;
use yii\validators\NumberValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

/**
 * Class `Profile`
 * ===============
 *
 * This is the model class for table "{{%user_profile}}".
 *
 *
 * Available table columns:
 * ------------------------
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $surname
 * @property string $photo
 * @property string $country
 * @property string $city
 * @property string $state
 * @property string $address
 * @property string $postcode
 * @property string $location_latitude
 * @property string $location_longitude
 *
 * Available AR relations:
 * -----------------------
 *
 * @property User $user
 *
 */
class Profile extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%user_profile}}';
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
            [['name', 'surname', 'country', 'city', 'state', 'address', 'postcode', 'location_latitude', 'location_longitude'], StringValidator::class, 'max' => 64],

            // Image validation
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],

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
            'user_id' => Yii::t('common', 'User ID'),
            'name' => Yii::t('common', 'Name'),
            'surname' => Yii::t('common', 'Surname'),
            'photo' => Yii::t('common', 'Photo'),
            'country' => Yii::t('common', 'Country'),
            'city' => Yii::t('common', 'City'),
            'state' => Yii::t('common', 'State'),
            'address' => Yii::t('common', 'Address'),
            'postcode' => Yii::t('common', 'Postcode'),
            'location_latitude' => Yii::t('common', 'Latitude'),
            'location_longitude' => Yii::t('common', 'Longitude'),
        ];
    }

    /**
     * Returns related user.
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])
            ->inverseOf('profile');
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        if (!empty($this->photo)) {
            return $this->photo;
        }

        return '/img/no-avatar.jpg';
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return trim("{$this->name} {$this->surname}");
    }

}
