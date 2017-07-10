<?php

namespace kodi\backend\controllers;

use Ramsey\Uuid\Uuid;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

/**
 * Class `BaseController`
 * ======================
 *
 * This is a base controller for internal application pages.
 */
abstract class BaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = '@app/themes/admire/views/layouts/main';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [

            // Access control
            'accessInternal' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->getIsAdmin();
                        }
                    ],
                ],
            ],
        ]);
    }

    /**
     * Uploads file to the server by giving db instance
     *
     * @param $model
     * @param $field
     * @param null|string $currentPhoto
     * @return string uploaded file url
     * @throws ServerErrorHttpException
     */
    public function uploadFile($model, $field, $currentPhoto = null)
    {
        $file = UploadedFile::getInstance($model, $field);
        if (!empty($file)) {
            $uuId = Uuid::uuid4();
            $filePath = '/img/uploads/' . $uuId . '.' . $file->extension;
            if ($file->saveAs(Yii::getAlias('@webroot') . $filePath)) {
                return $filePath;
            }

            throw new ServerErrorHttpException();
        }

        return $currentPhoto;
    }

    /**
     * Removes file from server
     *
     * @param $filePath
     * @return bool
     */
    public function removeFile($filePath)
    {
        $path = Yii::getAlias('@webroot') . $filePath;
        if (unlink($path)) {
            return true;
        }

        return false;
    }
}
