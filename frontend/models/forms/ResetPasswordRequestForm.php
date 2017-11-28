<?php
namespace kodi\frontend\models\forms;

use kodi\common\enums\user\Status;
use kodi\common\enums\user\TokenType;
use kodi\common\models\user\User;
use Yii;
use yii\base\Model;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\validators\EmailValidator;
use yii\validators\ExistValidator;
use yii\validators\RequiredValidator;

/**
 * Class ResetPasswordRequestForm
 * ==============================
 *
 * Password reset request form
 */
class ResetPasswordRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            // Required fields
            [['email'], RequiredValidator::class],

            // Strings validation
            [['email'], EmailValidator::class],
            ['email', ExistValidator::class,
                'targetClass' => User::class,
                'filter' => ['status' => Status::ACTIVE],
                'message' => Yii::t('frontend', 'There is no user with such email address.'),
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => Status::ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        $tokenData = Yii::$app->security->generateToken($user->id, TokenType::PASSWORD_RESET);
        $token = base64_encode(Json::encode($tokenData));
        $resetTokenUrl = str_replace('api.', '', Url::to(["/auth/password-reset/{$token}"], true));

        return Yii::$app->mailer->compose('password-reset-token', [
            'user' => $user,
            'resetLink' => $resetTokenUrl,
        ])
            ->setFrom([Yii::$app->settings->get('system_email_sender') => Yii::$app->name])
            ->setTo($this->email)
            ->setSubject(Yii::$app->name . ': Password reset')
            ->send();
    }
}
