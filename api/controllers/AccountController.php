<?php
namespace kodi\api\controllers;

use app\components\auth\KodiAuth;
use kodi\common\models\user\Profile;
use Yii;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class AccountController
 * =======================
 *
 * @package kodi\api\controllers
 */
class AccountController extends Controller
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
     * Saves profile info
     *
     * @return Profile
     * @throws ErrorException
     */
    public function actionSaveProfile()
    {
        $userId = Yii::$app->user->identity->getId();
        $data = Yii::$app->getRequest()->getBodyParams();
        $profile = Profile::findOne(['user_id' => $userId]);
        $profile->load($data, '');
        if ($profile->save()) {
            return $profile;
        }

        throw new ErrorException('Unable to save user information.');
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