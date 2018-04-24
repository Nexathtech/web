<?php
namespace kodi\frontend\controllers;

use kodi\frontend\models\forms\BecomeBrandForm;
use kodi\frontend\models\forms\ContactForm;
use kodi\frontend\models\forms\SubscribeForm;
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
     * Temporary action. Landing home page
     *
     * @return string
     */
    public function actionPlus()
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

        return $this->render('plus', ['subscribeModel' => $model]);
    }

    /**
     * @return string
     */
    public function actionBrands()
    {
        $model = new BecomeBrandForm();

        if ($model->load(Yii::$app->request->post())) {
            $alertType = 'error';
            $alertMessage = Yii::t('frontend', 'An error occurred. Please try again later.');

            if ($model->validate() && $model->sendEmail()) {
                $alertType = 'success';
                $alertMessage = Yii::t('frontend', 'Your request was successfully sent.');

                // Send a message to admin
                $contact = new ContactForm([
                    'email' => $model->email,
                    'body' => Yii::t('frontend', 'User {email} has requested to become a brand.', ['email' => $model->email]),
                    'subject' => Yii::t('frontend', 'Request to become a brand'),
                ]);
                $contact->sendEmail();
            }
            Yii::$app->session->addFlash($alertType, ['message' => $alertMessage]);
        }

        return $this->render('brands', ['becomeBrandModel' => $model]);
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
                $alertMessage = Yii::t('frontend', 'Your message was successfully sent.');
            }
            Yii::$app->session->addFlash($alertType, ['message' => $alertMessage]);
        }

        return $this->render('about', ['model' => $contactModel]);
    }
}
