<?php

namespace kodi\backend\controllers;

use kodi\common\enums\AlertType;
use kodi\common\enums\setting\Type;
use kodi\common\models\Setting;
use Yii;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Class `SettingsController`
 * ==========================
 *
 * This controller is responsible for configuring system settings.
 */
final class SettingsController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            // Negotiator filter
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'only' => ['delete-photo'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ]);
    }

    /**
     * Lists all settings.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $settings = Setting::find()->orderBy('sort_order')->all();
        $fields = [];
        foreach ($settings as $setting) {
            /** @var $setting Setting */
            $fields[$setting->bunch][] = $setting;
        }

        if (Yii::$app->request->post('Setting')) {
            foreach ($settings as $i => $setting) {
                if (isset($_POST['Setting'][$setting->name])) {
                    if ($setting->type === Type::IMAGE) {
                        $file = UploadedFile::getInstanceByName("Setting[{$setting->name}][value]");
                        if (!empty($file)) {
                            $filePath = '/img/uploads/' . $setting->name . '.' . $file->extension;
                            if ($file->saveAs(Yii::getAlias('@webroot') . $filePath)) {
                                $settings[$i]->value = Url::base(true) . $filePath;
                            }
                        }
                    } else {
                        $settings[$i]->value = $_POST['Setting'][$setting->name]['value'];
                    }

                    if ($settings[$i]->save()) {
                        Yii::$app->session->addFlash(AlertType::SUCCESS, [
                            'message' => Yii::t('backend', 'Changes successfully saved!'),
                        ]);
                    }
                }
            }
        }

        return $this->render('index', ['fields' => $fields]);
    }

    /**
     * Removes specified photo
     *
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionDeletePhoto($id)
    {
        $result = [];
        $device = $this->findModel($id);
        $device->value = null;
        if ($device->save(false)) {
            $result['status'] = 'success';
        } else {
            $result['status'] = 'error';
            $result['description'] = Yii::t('backend', 'Unable to unset image');
        }

        return $result;
    }

    /**
     * Creates a new settings variable
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Setting();
        $bunches = Setting::find()->select('bunch')->distinct()->asArray()->column();
        $bunchesData = [];
        foreach ($bunches as $bunch) {
            $bunchesData[$bunch] = $bunch;
        }

        // Form data received
        $postData = Yii::$app->request->post();
        if ($model->load($postData) && $model->save()) {
            // Record saved
            Yii::$app->session->addFlash(AlertType::SUCCESS, [
                'message' => Yii::t('backend', 'New variable has been successfully created.'),
            ]);
            return $this->redirect(['index']);
        }

        // Render page
        return $this->render('create', [
            'model' => $model,
            'bunches' => $bunchesData,
        ]);
    }

    /**
     * Finds instance model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id Record ID.
     * @return Setting The loaded model.
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Setting::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}
