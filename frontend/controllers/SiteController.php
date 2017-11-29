<?php
namespace kodi\frontend\controllers;

use kodi\frontend\models\forms\ContactForm;
use Yii;
use yii\base\ViewNotFoundException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
     * Displays homepage.
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {

        return $this->render('index');
    }

    /**
     * Displays a page with slug given.
     * Currently - station, printing, plus and koders pages
     *
     * @param string $slug
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        try {
            return $this->render($slug);
        } catch (ViewNotFoundException $e) {
            throw new NotFoundHttpException;
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        $contactModel = new ContactForm();
        $alertType = 'error';
        $alertMessage = Yii::t('frontend', 'An error occurred. Please try again later.');
        if ($contactModel->load(Yii::$app->request->post())) {
            if ($contactModel->validate() && $contactModel->sendEmail()) {
                $alertType = 'success';
                $alertMessage = Yii::t('frontend', 'Thanks! Your message was successfully sent.');
            }
            Yii::$app->session->addFlash($alertType, ['message' => $alertMessage]);
        }

        return $this->render('about', ['model' => $contactModel]);
    }
}
