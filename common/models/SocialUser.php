<?php

namespace kodi\common\models;

use kodi\common\behaviors\TimestampBehavior;
use Yii;
use yii\db\ActiveRecord;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

/**
 * Class `SocialUser`
 * ==================
 *
 * This is the model class for table "{{%social_user}}".
 * It stores users from social networks like facebook
 *
 * Available table columns:
 * ------------------------
 *
 * @property integer $id
 * @property integer $uuid
 * @property string $name
 * @property string $photo
 * @property string $gender
 * @property string $profile_url
 * @property string $type
 * @property string $created_at
 *
 */
class SocialUser extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%social_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [

            // Required fields
            [['uuid'], RequiredValidator::class],

            // Strings validation
            [['photo', 'profile_url'], StringValidator::class, 'max' => 255],
            [['name', 'gender', 'type'], StringValidator::class, 'max' => 64],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'uuid' => Yii::t('common', 'User Unique Id'),
            'name' => Yii::t('common', 'Full Name'),
            'photo' => Yii::t('common', 'Photo'),
            'gender' => Yii::t('common', 'Gender'),
            'type' => Yii::t('common', 'Type'),
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
