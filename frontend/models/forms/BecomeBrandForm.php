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
 * Class BecomeBrandForm
 * =====================
 *
 * Become a brand form
 */
class BecomeBrandForm extends Model
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
            /*['email', ExistValidator::class,
                'targetClass' => User::class,
                'filter' => ['status' => Status::ACTIVE],
                'message' => Yii::t('frontend', 'There is no user with such email address.'),
            ],*/
        ];
    }

    /**
     * Sends an email to the user
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        /*$user = User::findOne([
            'status' => Status::ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }*/

        // Send email to the user
        return Yii::$app->mailer->compose('become-brand')
            ->setFrom([Yii::$app->settings->get('system_email_sender') => Yii::t('frontend', 'Kodi Team')])
            ->setTo($this->email)
            ->setSubject(Yii::t('frontend', 'Become a brand member'))
            ->send();
    }

}
