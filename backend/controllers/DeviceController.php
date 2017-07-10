<?php

namespace kodi\backend\controllers;

use kodi\common\enums\AlertType;
use kodi\common\models\device\search\Device as DeviceSearch;
use kodi\common\models\device\Device;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class `DeviceController`
 * ========================
 *
 * This controller is responsible for users (customers) management.
 */
class DeviceController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [

            // Verbs filter
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],

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
     * Lists all instances.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeviceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        // Render page
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays details about existing instance.
     *
     * @param integer $id Record ID.
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing instance.
     *
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id Record ID.
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Form data received
        $postData = Yii::$app->request->post();
        $currentPhoto = $model->photo;
        if ($model->load($postData)) {
            // new photo could be uploaded
            $model->photo = $this->uploadFile($model, 'photo', $currentPhoto);

            if ($model->save()) {
                // Record saved
                Yii::$app->session->addFlash(AlertType::SUCCESS, [
                    'message' => Yii::t('backend', 'Device "{name}" has been successfully updated.', [
                        'name' => $model->name,
                    ]),
                ]);
                return $this->redirect(['index']);
            }
        }

        // Render page
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Creates new device
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Device();

        // Form data received
        $postData = Yii::$app->request->post();
        if ($model->load($postData)) {
            $model->photo = $this->uploadFile($model, 'photo');

            if ($model->save()) {
                // Record saved
                Yii::$app->session->addFlash(AlertType::SUCCESS, [
                    'message' => Yii::t('backend', 'New device has been successfully created.'),
                ]);
                return $this->redirect(['index']);
            }
        }

        // Render page
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing instance.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id Record ID.
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Removes device's photo
     *
     * @param $id
     * @return array
     */
    public function actionDeletePhoto($id)
    {
        $result = [];
        $device = $this->findModel($id);
        $photoPAth = $device->photo;
        $device->photo = null;
        if ($this->removeFile($photoPAth)) {
            // The file from server has been successfully removed
            $device->save(false);
            $result['status'] = 'success';
        } else {
            $result['status'] = 'error';
            $result['description'] = Yii::t('backend', 'Unable to remove "{file}" from server', ['{file}' => $photoPAth]);
        }

        return $result;
    }

    /**
     * Finds instance model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id Record ID.
     * @return Device The loaded model.
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Device::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}