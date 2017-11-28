<?php

namespace kodi\backend\controllers;

use kodi\common\enums\action\Status;
use kodi\common\models\Action;
use kodi\common\models\ActionSearch;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class `ActionController`
 * ========================
 *
 * This controller is responsible for third parties' actions management.
 */
class ActionController extends BaseController
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
                    'delete, archive' => ['POST'],
                ],
            ],

            // Negotiator filter
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'only' => ['archive'],
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
        $searchModel = new ActionSearch();
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
     * Changes the status of the action to archived
     *
     * @param $id
     * @return array
     */
    public function actionArchive($id)
    {
        $action = $this->findModel($id);
        $action->status = Status::ARCHIVED;
        $data = [
            'status' => 'error',
            'message' => Yii::t('backend', 'An error occurred.'),
        ];
        if ($action->save(false)) {
            $data['status'] = 'success';
            $data['message'] = Yii::t('backend', 'Status of the action has been successfully changed!');
        }

        return $data;
    }

    /**
     * Finds instance model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id Record ID.
     * @return Action The loaded model.
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Action::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}