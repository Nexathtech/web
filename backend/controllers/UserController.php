<?php

namespace kodi\backend\controllers;

use kodi\common\enums\AlertType;
use kodi\common\models\user\Profile;
use kodi\common\models\user\search\User as UserSearch;
use kodi\common\models\user\User;
use Yii;
use yii\base\Model;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

/**
 * Class `UserController`
 * =====================
 *
 * This controller is responsible for users (customers) management.
 */
class UserController extends BaseController
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
                    'suspend' => ['POST'],
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
     * Lists all users accounts.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        // Render page
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays details about existing user (customer).
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
     * Updates an existing user's account.
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
        $currentPhoto = $model->profile->photo;
        if ($model->load($postData) && $model->profile->load($postData) && Model::validateMultiple([$model, $model->profile])) {
            // new photo could be uploaded
            $model->profile->photo = $this->uploadFile($model->profile, 'photo', $currentPhoto);

            if ($model->save() && $model->profile->save()) {
                // User settings now
                if (Yii::$app->request->post('Settings')) {
                    foreach ($model->settings as $setting) {
                        if (isset($_POST['Settings'][$setting->key])) {
                            $setting->value = $_POST['Settings'][$setting->key]['value'];
                            $setting->save(false);
                        }
                    }
                }

                // Record saved
                Yii::$app->session->addFlash(AlertType::SUCCESS, [
                    'message' => Yii::t('backend', 'User "{name}" has been successfully updated.', [
                        'name' => $model->profile->name,
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
     * Creates new user
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();
        $profileModel = new Profile();

        // Form data received
        $postData = Yii::$app->request->post();
        if ($model->load($postData) && $profileModel->load($postData)) {
            if ($model->save()) {
                $profileModel->user_id = $model->id;
                $profileModel->photo = $this->uploadFile($profileModel, 'photo');
                $profileModel->save(false);

                // Record saved
                Yii::$app->session->addFlash(AlertType::SUCCESS, [
                    'message' => Yii::t('backend', 'New user has been successfully created.'),
                ]);
                return $this->redirect(['index']);
            }
        }

        // Render page
        return $this->render('create', [
            'model' => $model,
            'profileModel' => $profileModel,
        ]);
    }

    /**
     * Deletes an existing user.
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
     * Removes user's photo
     *
     * @param $id
     * @return array
     */
    public function actionDeletePhoto($id)
    {
        $result = [];
        $profile = $this->findModel($id)->profile;
        $photoPAth = $profile->photo;
        $profile->photo = null;
        if ($this->removeFile($photoPAth)) {
            // The file from server has been successfully removed
            $profile->save(false);
            $result['status'] = 'success';
        } else {
            $result['status'] = 'error';
            $result['description'] = Yii::t('backend', 'Unable to remove "{file}" from server', ['{file}' => $photoPAth]);
        }

        return $result;
    }

    /**
     * Finds user model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id Record ID.
     * @return User The loaded model.
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = User::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}