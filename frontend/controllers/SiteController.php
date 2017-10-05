<?php
namespace kodi\frontend\controllers;

use kodi\frontend\models\forms\SubscribeForm;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage with subscribe form.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new SubscribeForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $subscriptionRes = $model->subscribe();
            $alertType = 'error';
            if ($subscriptionRes['success']) {
                $alertType = 'success';
            }
            Yii::$app->session->addFlash($alertType, ['message' => $subscriptionRes['message']]);
        }

        return $this->render('index', ['subscribeModel' => $model]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
