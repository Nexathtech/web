<?php
namespace kodi\frontend\controllers;

use kodi\common\enums\Status;
use kodi\common\models\page\Page;
use kodi\frontend\models\forms\ContactForm;
use Yii;
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
     * Displays homepage with subscribe form.
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $page = Page::find()->where(['alias' => 'homepage', 'status' => Status::ACTIVE])->one();
        if (empty($page)) {
            throw new NotFoundHttpException;
        }

        return $this->render('index', ['content' => $page]);
    }

    /**
     * Displays a page with slug given.
     *
     * @param string $slug
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        // Do not allow homepage to show on page different from home page
        if ($slug !== 'homepage' && $slug !== 'about') {
            $page = Page::find()->where(['alias' => $slug, 'status' => Status::ACTIVE])->one();
        }
        if (empty($page)) {
            throw new NotFoundHttpException;
        }

        return $this->render('view', [
            'content' => $page,
        ]);
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
