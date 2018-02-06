<?php
namespace kodi\frontend\controllers;

use kodi\common\models\user\User;
use kodi\frontend\models\forms\ContactForm;
use kodi\frontend\models\forms\SubscribeForm;
use Yii;
use yii\base\ViewNotFoundException;
use yii\helpers\Url;
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
        $user = User::findOne(['id' => 5]);
        $confirmationUrl = str_replace('api.', '', Url::to(["/auth/activate/sdfsd"], true));

        Yii::$app->mailer->compose('welcome', [
            'user' => $user,
            'confirmationUrl' => $confirmationUrl,
        ])
            ->setFrom(Yii::$app->settings->get('system_email_sender'))
            ->setTo($user->email)
            ->setSubject(Yii::t('api', 'KODI: Account activation'))
            ->send();


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
