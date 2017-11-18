<?php

namespace kodi\common\models\page;

use kodi\common\behaviors\TimestampBehavior;
use kodi\common\enums\Status;
use Yii;
use yii\db\ActiveRecord;
use yii\validators\RangeValidator;

/**
 * Class `Page`
 * ============
 *
 * This is the model class for table "{{%page}}".
 *
 * Available table columns:
 * ------------------------
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $text
 * @property integer $status
 * @property string $script
 * @property string $meta_description
 * @property string $meta_keywords
 * @property integer $created_at
 * @property integer $updated_at
 */
class Page extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            // Required fields
            [['title', 'alias', 'text'], 'required'],

            // Strings validation
            [['text', 'script'], 'string'],
            [['title', 'alias', 'meta_description', 'meta_keywords'], 'string', 'max' => 255],

            // Range validation
            ['status', RangeValidator::class, 'range' => array_keys(Status::listData())],
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
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'alias' => Yii::t('app', 'Alias'),
            'text' => Yii::t('app', 'Text'),
            'status' => Yii::t('app', 'Status'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}