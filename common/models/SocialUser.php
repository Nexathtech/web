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
     * @var string
     */
    const TYPE_FACEBOOK = 'Facebook';

    /**
     * @var string
     */
    const TYPE_INSTAGRAM = 'Instagram';

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

            // Range validation
            ['type', RangeValidator::class, 'range' => [self::TYPE_FACEBOOK, self::TYPE_INSTAGRAM]],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('kodi/common', 'ID'),
            'uuid' => Yii::t('kodi/common', 'User Unique Id'),
            'name' => Yii::t('kodi/common', 'Full Name'),
            'photo' => Yii::t('kodi/common', 'Photo'),
            'gender' => Yii::t('kodi/common', 'Gender'),
            'type' => Yii::t('kodi/common', 'Type'),
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
