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
        return Yii::t('app', 'It works!');
    }
}
