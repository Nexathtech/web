<?php

namespace kodi\common\models;

use Imagine\Image\Box;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\validators\FileValidator;
use yii\web\UploadedFile;

/**
 * Class `ImageFile`
 * =================
 *
 * This is the model class for image uploading.
 */
class ImageFile extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $images;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            // Image validator. Max file size: 5MB
            [['images'], FileValidator::class, 'skipOnEmpty' => false, 'mimeTypes' => 'image/jpeg, image/png', 'maxFiles' => ArrayHelper::getValue(Yii::$app->params, 'files.maxFiles', 0), 'maxSize' => ArrayHelper::getValue(Yii::$app->params, 'files.maxSize', 1024 * 1024 * 5)],
        ];
    }

    /**
     * Uploads files to internal server
     *
     * @return array|null
     */
    public function upload()
    {
        if ($this->validate()) {
            $userId = Yii::$app->user->getId();
            $savedFiles = [];
            foreach ($this->images as $file) {
                $fileName = basename($file->name);
                $dir = Yii::getAlias('@webroot') . "/uploads/$userId";
                $filePath = "$dir/$fileName";
                if (FileHelper::createDirectory($dir)) {
                    if ($file->saveAs($filePath)) {
                        $imagine = Image::getImagine();
                        $image = $imagine->open($filePath);
                        $maxWidth = ArrayHelper::getValue(Yii::$app->params, 'files.images.maxWidth', 500);
                        $maxHeight = ArrayHelper::getValue(Yii::$app->params, 'files.images.maxHeight', 500);
                        $image->thumbnail(new Box($maxWidth, $maxHeight))->save($filePath, ['quality' => 80]);
                        $fileUrl = Url::to("/uploads/$userId/$fileName", true);
                        array_push($savedFiles, $fileUrl);
                    }
                }
            }

            return $savedFiles;
        }

        return null;
    }

}
