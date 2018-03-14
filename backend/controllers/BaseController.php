<?php

namespace kodi\backend\controllers;

use Ramsey\Uuid\Uuid;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;
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
     * @param string $subPath
     * @return string uploaded file url
     * @throws ServerErrorHttpException
     */
    public function uploadFile($model, $field, $currentPhoto = null, $subPath = '')
    {
        $file = UploadedFile::getInstance($model, $field);
        if (!empty($file)) {
            $uuId = (string)Uuid::uuid4();
            $fileName = "{$uuId}.{$file->extension}";
            $dir = Yii::getAlias('@webroot') . "/img/uploads/{$subPath}";
            $filePath = "$dir/$fileName";
            if (FileHelper::createDirectory($dir)) {
                if ($file->saveAs($filePath)) {
                    return Url::to("/img/uploads/{$subPath}{$fileName}");
                }
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
