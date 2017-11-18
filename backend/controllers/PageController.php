<?php

namespace kodi\backend\controllers;

use kodi\common\enums\AlertType;
use kodi\common\models\page\search\Page as PageSearch;
use kodi\common\models\page\Page;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * Class `PageController`
 * ======================
 *
 * This controller is responsible for pages management.
 */
class PageController extends BaseController
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
        $searchModel = new PageSearch();
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
        if ($model->load($postData) && $model->save()) {
            // Record saved
            Yii::$app->session->addFlash(AlertType::SUCCESS, [
                'message' => Yii::t('backend', 'Page "{title}" has been successfully updated.', [
                    'title' => $model->title,
                ]),
            ]);
            return $this->redirect(['index']);
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
        $model = new Page();

        // Form data received
        $postData = Yii::$app->request->post();
        if ($model->load($postData) && $model->save()) {
            // Record saved
            Yii::$app->session->addFlash(AlertType::SUCCESS, [
                'message' => Yii::t('backend', 'New page has been successfully created.'),
            ]);
            return $this->redirect(['index']);
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
     * Finds instance model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id Record ID.
     * @return Page The loaded model.
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Page::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}