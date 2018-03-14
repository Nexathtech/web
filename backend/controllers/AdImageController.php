<?php

namespace kodi\backend\controllers;

use kodi\common\enums\AlertType;
use kodi\common\models\AdImage;
use kodi\common\models\AdImageSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * Class `AdImageController`
 * ========================
 *
 * This controller is responsible for advertisement images management.
 */
class AdImageController extends BaseController
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
        ]);
    }

    /**
     * Lists all instances.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        // Render page
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates new device
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new AdImage();

        // Form data received
        $postData = Yii::$app->request->post();
        if ($model->load($postData)) {
            $model->image = $this->uploadFile($model, 'image', null, 'print-presets/');

            if ($model->save()) {
                // Record saved
                Yii::$app->session->addFlash(AlertType::SUCCESS, [
                    'message' => Yii::t('backend', 'New image has been successfully created.'),
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
        if ($model->load($postData)) {
            if ($model->save()) {
                // Record saved
                Yii::$app->session->addFlash(AlertType::SUCCESS, [
                    'message' => Yii::t('backend', 'Image "{id}" has been successfully updated.', [
                        'id' => $model->id,
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
     * Deletes an existing instance.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id Record ID.
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            Yii::$app->session->addFlash(AlertType::SUCCESS, [
                'message' => Yii::t('backend', 'The image has been successfully deleted.'),
            ]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds instance model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id Record ID.
     * @return AdImage The loaded model.
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = AdImage::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}