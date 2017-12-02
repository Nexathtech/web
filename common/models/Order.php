<?php

namespace kodi\common\models;

use kodi\common\behaviors\TimestampBehavior;
use kodi\common\enums\order\PaymentType;
use kodi\common\enums\order\Status;
use kodi\common\models\device\Device;
use kodi\common\models\user\User;
use Yii;
use yii\db\ActiveRecord;
use yii\validators\EmailValidator;
use yii\validators\NumberValidator;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\SafeValidator;
use yii\validators\StringValidator;

/**
 * Class `Order`
 * =============
 *
 * This is the model class for table "{{%order}}".
 *
 *
 * Available table columns:
 * ------------------------
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $company
 * @property string $country
 * @property string $city
 * @property string $state
 * @property string $address
 * @property string $postcode
 * @property string $color
 * @property integer $quantity
 * @property string $payment_type
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 *
 * Available AR relations:
 * -----------------------
 * @property User $user
 * @property Device $device
 */
class Order extends ActiveRecord
{
    /**
     * @var string address additional field
     */
    public $address2;

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            // required fields
            [['name', 'surname', 'email', 'country', 'city', 'address', 'color'], RequiredValidator::class],

            // email has to be a valid email address
            ['email', EmailValidator::class],

            // number fields
            [['quantity'], NumberValidator::class, 'min' => 1, 'max' => 5],

            // Range validation
            ['status', RangeValidator::class, 'range' => array_keys(Status::listData())],
            ['payment_type', RangeValidator::class, 'range' => array_keys(PaymentType::listData())],

            // safe fields
            [['company', 'address2', 'state', 'postcode'], StringValidator::class],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Name'),
            'surname' => Yii::t('common', 'Surname'),
            'email' => Yii::t('common', 'Email'),
            'company' => Yii::t('common', 'Company'),
            'country' => Yii::t('common', 'Country'),
            'city' => Yii::t('common', 'City'),
            'state' => Yii::t('common', 'State'),
            'address' => Yii::t('common', 'Address'),
            'address2' => Yii::t('common', 'Address line 2'),
            'postcode' => Yii::t('common', 'Postcode'),
            'color' => Yii::t('common', 'Color'),
            'quantity' => Yii::t('common', 'Quantity'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
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
            ],
        ];
    }

}
