<?php

namespace kodi\backend\controllers;

use kodi\backend\models\forms\SignInForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * Class `AuthController`
 * ======================
 *
 * This controller is responsible for user authentication.
 */
final class AuthController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = 'auth';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [

            // Access control
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['sign-out'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Signs user in.
     *
     * @return mixed
     */
    public function actionSignIn()
    {
        $model = new SignInForm();

        // Form data received
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        // Render page
        return $this->render('sign-in', [
            'model' => $model,
        ]);
    }

    /**
     * Signs out the current user.
     *
     * @return mixed
     */
    public function actionSignOut()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
