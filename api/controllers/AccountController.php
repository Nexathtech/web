<?php
namespace kodi\api\controllers;

use app\components\auth\KodiAuth;
use kodi\api\components\Controller;
use kodi\common\enums\user\Type;
use kodi\common\models\ImageFile;
use kodi\common\models\user\Profile;
use kodi\common\models\user\Settings;
use kodi\common\models\user\User;
use Yii;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;

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
     * @return array
     * @throws ErrorException
     */
    public function actionSaveProfile()
    {
        $userId = Yii::$app->user->identity->getId();
        $data = Yii::$app->getRequest()->getBodyParams();
        $profile = Profile::findOne(['user_id' => $userId]);
        $profile->load($data, '');
        if ($profile->save()) {
            if (!empty($data['settings'])) {
                foreach ($data['settings'] as $key => $setting) {
                    Settings::updateAll(['value' => $setting], ['key' => $key, 'user_id' => $userId]);
                }
            }
            return [
                'info' => $profile,
                'settings' => $profile->user->getVerboseSettings(),
            ];
        }

        throw new ErrorException(Yii::t('api', 'Unable to save user information.'));
    }

    /**
     * Uploads images to internal server
     *
     * @return array|null|\yii\console\Response|\yii\web\Response
     * @throws ErrorException
     */
    public function actionUploadImages()
    {
        //return $_FILES;
        $model = new ImageFile();
        $model->images = UploadedFile::getInstances($model, 'images');

        if ($model->validate()) {
            if ($uploadedImages = $model->upload()) {
                return $uploadedImages;
            }
        } else {
            $response = Yii::$app->response;
            $response->statusCode = 400;
            $response->data = $model->errors;
            return $response;
        }

        throw new ErrorException(Yii::t('api', 'Could not upload the file(s).'));
    }

    /**
     * Requests to change user type
     *
     * @throws BadRequestHttpException
     * @throws ForbiddenHttpException
     */
    public function actionChangeType()
    {
        /* @var $user User */
        $user = Yii::$app->user->identity;
        $type = ucfirst(Yii::$app->request->post('type'));
        $allowedTypes = array_keys(Type::listData());

        if ($user->type === $type) {
            throw new ForbiddenHttpException(Yii::t('api', 'You are already a {type} user.', ['type' => $user->type]));
        } else {
            if (in_array($type, $allowedTypes)) {
                $adminEmail = Yii::$app->settings->get('system_email_sender');
                $urlToUpdate = Url::to(['/user/update', 'id' => $user->id], true);
                $urlToUpdate = Html::a($user->id, str_replace('api', 'backend', $urlToUpdate));

                Yii::$app->mailer->compose('clear', [
                    'content' => "User #{$urlToUpdate} ({$user->email}) requested type change to {$type}",
                ])
                    ->setFrom([$adminEmail => Yii::t('api', 'Kodi Team')])
                    ->setTo($adminEmail)
                    ->setReplyTo($user->email)
                    ->setSubject('Type change request')
                    ->send();

                return Yii::t('api', 'Thank you. Your request is successfully obtained. We will consider it asap.');
            }
        }

        throw new BadRequestHttpException(Yii::t('api', 'Unsupported type.'));
    }

}