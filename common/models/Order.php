<?php

namespace kodi\common\models;

use kodi\common\behaviors\TimestampBehavior;
use kodi\common\enums\order\OrderType;
use kodi\common\enums\order\PaymentType;
use kodi\common\enums\order\Status;
use kodi\common\models\device\Device;
use kodi\common\models\user\User;
use kodi\frontend\models\forms\ContactForm;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
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
 * @property integer $user_id
 * @property string $type
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $company
 * @property string $country
 * @property string $city
 * @property string $state
 * @property string $address
 * @property string $postcode
 * @property string $location_latitude
 * @property string $location_longitude
 * @property string $color
 * @property integer $quantity
 * @property float $total
 * @property string $payment_type
 * @property string $payment_data
 * @property string $order_data
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 *
 * Available AR relations:
 * -----------------------
 * @property User $user
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
            [['quantity'], NumberValidator::class, 'min' => 1, 'max' => 1000],
            [['user_id', 'total'], NumberValidator::class],

            // Range validation
            ['type', RangeValidator::class, 'range' => array_keys(OrderType::listData())],
            ['status', RangeValidator::class, 'range' => array_keys(Status::listData())],
            ['payment_type', RangeValidator::class, 'range' => array_keys(PaymentType::listData())],

            // safe fields
            [['company', 'address2', 'state', 'postcode', 'payment_data', 'order_data', 'location_latitude', 'location_longitude'], StringValidator::class],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User'),
            'type' => Yii::t('common', 'Type'),
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
            'total' => Yii::t('common', 'Total, $'),
            'payment_type' => Yii::t('common', 'Payment type'),
            'payment_data' => Yii::t('common', 'Payment data'),
            'order_data' => Yii::t('common', 'Order data'),
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

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $template = 'payment/none-success';
            $data = [];

            if ($this->payment_type === PaymentType::WIRETRANSFER) {
                $bankDetails = Yii::$app->settings->get([
                    'bank_beneficiary',
                    'bank_account_number',
                    'bank_swift_code',
                    'bank_name',
                    'bank_address',
                ]);
                $data = ArrayHelper::merge($this->getAttributes(), $bankDetails);
                $template = 'payment/wire-success';
            }

            if ($this->type === OrderType::PHOTO) {
                $data = [];
                $template = 'payment/photo-success';
            }

            // Send email to the user
            $this->sendEmail($template, $data, $this->email);

            // Send email to admin
            $contact = new ContactForm([
                'email' => $this->email,
                'body' => Yii::t('common', 'New order from {email}.', ['email' => $this->email]),
                'subject' => Yii::t('common', 'Kodi Order'),
            ]);
            $contact->sendEmail();

        } else {
            // Send email to user if status of the order changed
            if ($this->status !== $this->getOldAttribute('status')) {
                if ($this->status === Status::SHIPPED) {
                    $template = 'payment/status-changed';
                    if ($this->type === OrderType::PHOTO) {
                        $template = 'payment/photo-status-changed';
                    }
                    $this->sendEmail($template, $this->getAttributes(), $this->email);
                }
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if ($this->type === OrderType::PHOTO && !empty($this->order_data)) {
            $orderData = Json::decode($this->order_data);
            if (!empty($orderData['action_id'])) {
                Action::findOne(['id' => $orderData['action_id']])->delete();
            }
        }

        return parent::beforeDelete();
    }

    /**
     * Returns related user.
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Sends an email to the user about order status.
     *
     * @param $template
     * @param $data
     * @param $recipient
     * @param null $sender
     * @return bool whether the email was sent
     */
    public function sendEmail($template, $data, $recipient, $sender = null)
    {
        $lang = Yii::$app->language;
        // Change language to receiver's one
        if (!empty($this->user)) {
            Yii::$app->language = $this->user->getSetting('users_language', $lang);
        }

        $subject = Yii::t('common', 'Kodi Order');
        if (!$this->isNewRecord) {
            $subject = Yii::t('common', 'Order status update');
            if ($this->status === Status::COMPLETED) {
                $subject = Yii::t('common', 'Good News');
            }
        }
        if (!$sender) {
            $sender = [Yii::$app->settings->get('system_email_sender') => 'Kodi Team'];
        }

        $mail = Yii::$app->mailer->compose($template, [
            'data' => $data,
        ])
            ->setFrom($sender)
            ->setTo($recipient)
            ->setSubject($subject)
            ->send();

        // Change language back
        Yii::$app->language = $lang;

        return $mail;
    }

    /**
     * Returns amount of orders with new/pending status
     *
     * @return int|string
     */
    public static function getPendingAmount()
    {
        return self::find()->where([
            'or',
            ['status' => Status::WAITING],
            ['status' => Status::PENDING],
        ])->count();
    }

}
