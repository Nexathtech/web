<?php

namespace kodi\api\models\auth;

use kodi\common\models\user\User;
use Yii;
use yii\base\Model;
use yii\validators\EmailValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;
use yii\validators\UniqueValidator;

/**
 * Class `SignUp`
 * ==============
 *
 * This is the model class for "sign up" functionality specifically for users.
 */
class SignUp extends Model
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $email
     */
    public $email;

    /**
     * @var string $password
     */
    public $password;

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'name' => Yii::t('api', 'Name'),
            'email' => Yii::t('api', 'Email address'),
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
            [['email', 'password'], RequiredValidator::class],

            // Strings validation
            [['email'], EmailValidator::class],
            [['password'], StringValidator::class, 'min' => 6, 'max' => 64],
            [['name'], StringValidator::class],

            // Unique email
            ['email', UniqueValidator::class, 'targetClass' => User::class, 'targetAttribute' => 'email'],
        ];
    }
}
