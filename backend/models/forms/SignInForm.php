<?php

namespace kodi\backend\models\forms;

use kodi\common\enums\user\Role;
use kodi\common\models\user\User;
use Yii;
use yii\base\Model;
use yii\validators\EmailValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;
use yii\web\IdentityInterface;

/**
 * Class `SignInForm`
 * ==================
 *
 * This is the model class for "sign in" form.
 */
class SignInForm extends Model
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
     * @var IdentityInterface $_identity
     */
    private $_identity;

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'email' => Yii::t('backend', 'Email address'),
            'password' => Yii::t('backend', 'Password'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [

            // Required fields
            [['email', 'password'], RequiredValidator::class],

            // Strings validation
            [['email'], EmailValidator::class],
            [['password'], StringValidator::class, 'max' => 64],

            // Authenticate user
            [['password'], function () {
                $this->_identity = User::findOne(['email' => $this->email]);
                if (!$this->_identity || !$this->_identity->validatePassword($this->password)) {
                    $this->addError('password', Yii::t('backend', 'User with such credentials is not found.'));
                }
                if ($this->_identity && $this->_identity->role !== Role::ADMINISTRATOR) {
                    $this->addError('password', Yii::t('backend', 'You are not allowed to access this service.'));
                }
            }],
        ];
    }

    /**
     * Logs current user in.
     *
     * @return bool Operation result.
     */
    public function login()
    {
        if (!$this->validate()) {
            return false;
        }
        $duration = 60 * 60 * 6; // Session duration

        return Yii::$app->user->login($this->_identity, $duration);
    }
}
