<?php

namespace kodi\backend\controllers;

use kodi\common\enums\AlertType;
use kodi\common\models\event\search\Event as EventSearch;
use kodi\common\models\event\Event;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class `EventController`
 * =======================
 *
 * This controller is responsible for events management.
 */
class EventController extends BaseController
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
                'only' => ['delete-logo'],
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
        $searchModel = new EventSearch();
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
     * @throws NotFoundHttpException
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
     * @throws NotFoundHttpException
     * @throws \yii\web\ServerErrorHttpException
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->starts_at = "{$model->starts_at} - {$model->ends_at}";

        // Form data received
        $postData = Yii::$app->request->post();
        $currentLogo = $model->logo;
        if ($model->load($postData)) {
            // Split starts_at from range
            $tRange = explode(' - ', $model->starts_at);
            $model->starts_at = $tRange[0];
            $model->ends_at = $tRange[1];
            // new logo could be uploaded
            $logo = $this->uploadFile($model, 'logo', $currentLogo);
            if ($logo !== $currentLogo) {
                $model->logo = $logo ? Url::base(true) . $logo : null;
            }

            if ($model->save()) {
                // Record saved
                Yii::$app->session->addFlash(AlertType::SUCCESS, [
                    'message' => Yii::t('backend', 'Event "{name}" has been successfully updated.', [
                        'name' => $model->title,
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
     * Creates new event
     *
     * @return string|\yii\web\Response
     * @throws \yii\web\ServerErrorHttpException
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new Event();

        // Form data received
        $postData = Yii::$app->request->post();
        if ($model->load($postData)) {
            // Split starts_at from range
            $tRange = explode(' - ', $model->starts_at);
            $model->starts_at = $tRange[0];
            $model->ends_at = $tRange[1];
            $logo = $this->uploadFile($model, 'logo');
            $model->logo = $logo ? Url::base(true) . $logo : null;

            if ($model->save()) {
                // Record saved
                Yii::$app->session->addFlash(AlertType::SUCCESS, [
                    'message' => Yii::t('backend', 'New event has been successfully created.'),
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
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Removes event's logo
     *
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionDeleteLogo($id)
    {
        $result = [];
        $event = $this->findModel($id);
        $logoPAth = str_replace(Url::base(true), '', $event->logo);
        $event->logo = null;
        if ($this->removeFile($logoPAth)) {
            // The file from server has been successfully removed
            $event->save(false);
            $result['status'] = 'success';
        } else {
            $result['status'] = 'error';
            $result['description'] = Yii::t('backend', 'Unable to remove "{file}" from server', ['{file}' => $logoPAth]);
        }

        return $result;
    }

    /**
     * Finds instance model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id Record ID.
     * @return Event The loaded model.
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Event::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}
