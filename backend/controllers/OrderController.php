<?php

namespace kodi\backend\controllers;

use kodi\common\enums\AlertType;
use kodi\common\enums\order\Status as OrderStatus;
use kodi\common\enums\Status;
use kodi\common\models\AdImage;
use kodi\common\models\Order;
use kodi\common\models\OrderSearch;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class `OrderController`
 * =======================
 *
 * This controller is responsible for orders management.
 */
class OrderController extends BaseController
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
                    'delete-cancelled' => ['POST'],
                    'delete-selected' => ['POST'],
                    'mark-selected' => ['POST'],
                ],
            ],

            // Negotiator filter
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'only' => ['mark'],
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
        $searchModel = new OrderSearch();
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
        $mLat = $model->location_latitude ?: 0;
        $mLon = $model->location_longitude ?: 0;
        $adImages = AdImage::find()
            ->select("ad_image.*, (3959 * acos(cos(radians({$mLat})) * cos(radians(ad_image.location_latitude)) * cos(radians(ad_image.location_longitude) - radians({$mLon})) + sin(radians({$mLat})) * sin(radians(ad_image.location_latitude)))) AS distance")
            ->where(['status' => Status::ACTIVE])
            ->orderBy(['distance' => SORT_ASC])
            ->asArray()
            ->all();

        return $this->render('view', [
            'model' => $model,
            'adImages' => $adImages,
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
        $postData = Yii::$app->request->post();
        if ($model->load($postData) && $model->save()) {
            // Record saved
            Yii::$app->session->addFlash(AlertType::SUCCESS, [
                'message' => Yii::t('backend', 'Order {id} has been successfully updated.', [
                    'id' => $model->id,
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
     * Deletes an existing instance.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id Record ID.
     * @return mixed
     */
    public function actionDelete($id)
    {
        $response = [
            'status' => AlertType::ERROR,
            'message' => Yii::t('backend', 'An error occurred.'),
        ];
        if ($this->findModel($id)->delete()) {
            $response['status'] = AlertType::SUCCESS;
            $response['message'] = Yii::t('backend', 'The order {id} has been successfully deleted.', [
                'id' => $id,
            ]);
        }

        Yii::$app->session->addFlash($response['status'], ['message' => $response['message']]);
        return $this->redirect(['index']);
    }

    /**
     * @return Response
     */
    public function actionDeleteCancelled()
    {
        $response = [
            'status' => AlertType::ERROR,
            'message' => Yii::t('backend', 'An error occurred.'),
        ];

        if (Order::deleteAll(['status' => OrderStatus::CANCELED])) {
            $response['status'] = AlertType::SUCCESS;
            $response['message'] = Yii::t('backend', 'Cancelled orders has been successfully deleted.');
        }

        Yii::$app->session->addFlash($response['status'], ['message' => $response['message']]);
        return $this->redirect(['index']);
    }

    /**
     * @return Response
     */
    public function actionDeleteSelected()
    {
        $response = [
            'status' => AlertType::ERROR,
            'message' => Yii::t('backend', 'An error occurred.'),
        ];

        $orders = explode(',', Yii::$app->request->getBodyParam('data'));
        if (Order::deleteAll(['id' => $orders])) {
            $response['status'] = AlertType::SUCCESS;
            $response['message'] = Yii::t('backend', 'Selected orders has been successfully deleted.');
        }

        Yii::$app->session->addFlash($response['status'], ['message' => $response['message']]);
        return $this->redirect(['index']);
    }

    /**
     * Changes (marks) order status to specified
     *
     * @param $id
     * @return array
     */
    public function actionMark($id)
    {
        $data = Yii::$app->request->getBodyParams();
        $response = [
            'status' => AlertType::ERROR,
            'message' => Yii::t('backend', 'An error occurred.'),
        ];

        if (!empty($data['status']) && in_array($data['status'], array_keys(OrderStatus::listData()))) {
            $model = $this->findModel($id);
            $model->status = $data['status'];
            if ($model->save(false)) {
                $response['status'] = AlertType::SUCCESS;
                $response['message'] = Yii::t('backend', 'The order has been successfully {status}.', [
                    'status' => $data['status'],
                ]);
            }
        }

        Yii::$app->session->addFlash($response['status'], ['message' => $response['message']]);
        return [];
    }

    /**
     * @param $status
     * @return Response
     */
    public function actionMarkSelected($status)
    {
        $response = [
            'status' => AlertType::ERROR,
            'message' => Yii::t('backend', 'An error occurred.'),
        ];

        if (!empty($status) && in_array($status, array_keys(OrderStatus::listData()))) {
            $orders = explode(',', Yii::$app->request->getBodyParam('data'));
            if (Order::updateAll(['status' => $status], ['id' => $orders])) {
                $response['status'] = AlertType::SUCCESS;
                $response['message'] = Yii::t('backend', 'Selected orders has been successfully updated.');
            }
        }

        Yii::$app->session->addFlash($response['status'], ['message' => $response['message']]);
        return $this->redirect(['index']);
    }

    /**
     * Finds instance model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id Record ID.
     * @return Order The loaded model.
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Order::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}