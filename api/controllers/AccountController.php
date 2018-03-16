<?php
namespace kodi\api\controllers;

use app\components\auth\KodiAuth;
use kodi\api\components\Controller;
use kodi\common\models\ImageFile;
use kodi\common\models\user\Profile;
use Yii;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
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

}