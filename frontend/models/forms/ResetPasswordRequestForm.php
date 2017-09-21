<?php
namespace kodi\frontend\models\forms;

use kodi\common\enums\user\Status;
use kodi\common\enums\user\TokenType;
use kodi\common\models\user\User;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

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
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => User::class,
                'filter' => ['status' => Status::ACTIVE],
                'message' => Yii::t('frontend', 'There is no user with this email address.'),
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
        
        $token = Yii::$app->security->generateToken($user->id, TokenType::PASSWORD_RESET);
        $resetTokenUrl = str_replace('api.', '', Url::to(["/auth/password-reset/$token"], true));
        return true;
        return Yii::$app->mailer->compose('password-reset-token', [
            'user' => $user,
            'resetLink' => $resetTokenUrl,
        ])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }
}
