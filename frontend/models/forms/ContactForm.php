<?php

namespace kodi\frontend\models\forms;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $email;
    public $body;
    public $subject;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['email', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }

    /**
     * Sends an email to the admin email address using the information collected by this model.
     *
     * @return bool whether the email was sent
     */
    public function sendEmail()
    {
        if (empty($this->subject)) {
            $this->subject = Yii::t('frontend', 'Kodi Team') . ': ' . Yii::t('frontend', 'Contact form');
        }
        $sender = Yii::$app->settings->get('system_email_sender');

        return Yii::$app->mailer->compose('clear', ['content' => $this->body])
            ->setFrom([$sender => Yii::t('frontend', 'Kodi Team')])
            ->setReplyTo($this->email)
            ->setTo('alex@kodiplus.io')
            ->setSubject($this->subject)
            ->send();
    }
}
