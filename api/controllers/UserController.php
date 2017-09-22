<?php
namespace kodi\api\controllers;

use app\components\auth\KodiAuth;
use Yii;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class UserController
 * ====================
 *
 * @package kodi\api\controllers
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => KodiAuth::class
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'get-countries' => ['get', 'post'],
            ],
        ];

        return $behaviors;
    }

    /**
     * Verifies promo code
     *
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionGetCountries()
    {
        return Yii::$app->settings->get('device_countries_support');
    }

}