<?php

namespace kodi\api\models\auth;

use kodi\common\enums\DeviceType;
use kodi\common\enums\user\Status;
use kodi\common\models\user\User;
use Yii;
use yii\base\Model;
use yii\validators\EmailValidator;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;
use yii\web\IdentityInterface;

/**
 * Class `SignIn`
 * =============
 *
 * This is the model class for "sign in" functionality specifically for devices.
 */
class SignIn extends Model
{
    /**
     * @var string $email
     */
    public $email;

    /**
     * @var string $password
     */
    public $password;

    /**
     * @var string $uuid Device's unique id
     */
    public $uuid;

    /**
     * @var string $type Device's type (Mobile or Kiosk)
     */
    public $type;

    /**
     * @var IdentityInterface $_identity
     */
    public $_identity;

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'email' => Yii::t('api', 'Email'),
            'password' => Yii::t('api', 'Password'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [

            // Required fields
            [['email', 'password', 'uuid', 'type'], RequiredValidator::class],

            // Strings validation
            [['email'], EmailValidator::class],
            [['password', 'uuid'], StringValidator::class, 'max' => 64],
            ['type', RangeValidator::class, 'range' => array_keys(DeviceType::listData())],

            // Authenticate user
            [['password'], function () {
                $this->_identity = User::findOne(['email' => $this->email]);
                if (!$this->_identity || !$this->_identity->validatePassword($this->password)) {
                    $this->addError('password', Yii::t('api', 'User with such credentials is not found.'));
                    return;
                }
                if ($this->_identity && $this->_identity->status === Status::INACTIVE) {
                    $this->addError('email', Yii::t('api', 'Your account is not activated.'));
                }
                if ($this->_identity && $this->_identity->status === Status::SUSPENDED) {
                    $this->addError('email', Yii::t('api', 'Your account is suspended.'));
                }
            }],
        ];
    }

}
