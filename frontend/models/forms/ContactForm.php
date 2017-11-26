<?php

namespace kodi\frontend\models\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $email;
    public $body;


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
        $subject = Yii::$app->name . ': ' . Yii::t('frontend', 'Contact form');

        return Yii::$app->mailer->compose()
            ->setFrom($this->email)
            ->setTo(Yii::$app->settings->get('system_email_sender'))
            ->setSubject($subject)
            ->setTextBody($this->body)
            ->send();
    }
}
