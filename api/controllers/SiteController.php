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
        return Yii::$app->mailer->compose()
            ->setFrom('admin@meetkodi.com')
            ->setTo('Footniko@gmail.com')
            ->setSubject('This is a test message')
            ->setTextBody('This is a plain text message content')
            ->send();

        //return Yii::t('app', 'It works!');
    }
}
