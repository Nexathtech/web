<?php

namespace kodi\api\controllers;

use Yii;
use yii\rest\Controller;

class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $to = 'Footniko@gmail.com';
        $subject = 'Simple Mail';
        $message = 'This is a text';
        $headers = 'From: webmaster@meetkodi.com' . "\r\n" .
            'Reply-To: webmaster@meetkodi.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        return Yii::$app->mailer->compose()
            ->setFrom('admin@meetkodi.com')
            ->setTo($to)
            ->setSubject('This is a test message')
            ->setTextBody('This is a plain text message content')
            ->send();

        //return Yii::t('app', 'It works!');
    }
}
