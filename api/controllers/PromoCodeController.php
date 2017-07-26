<?php
namespace kodi\api\controllers;

use app\components\auth\JwtAuth;
use Carbon\Carbon;
use kodi\common\enums\PromoCodeStatus;
use kodi\common\enums\SocialUserType;
use kodi\common\models\PromoCode;
use kodi\common\models\SocialUser;
use Yii;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Class PromoCodeController
 * =========================
 *
 * @package kodi\api\controllers
 */
class PromoCodeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => JwtAuth::className(),
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'create' => ['get', 'post'],
            ],
        ];

        return $behaviors;
    }

    /**
     * Creates promo code and social user if needed
     *
     * @return PromoCode|SocialUser
     * @throws ErrorException|ForbiddenHttpException
     */
    public function actionCreate()
    {
        $model = new PromoCode();
        $params = Yii::$app->getRequest()->getBodyParams();

        $model->code = PromoCode::generateRandomCode();
        $model->description = ArrayHelper::getValue($params, 'description');
        if (!empty($params['identity'])) {
            $identity = $params['identity'];
            // Check if user has already been used promo codes and return error
            if (!empty($identity['id'])) {
                if (!empty(PromoCode::findOne(['identity_id' => $identity['id'], 'status' => PromoCodeStatus::USED]))) {
                    throw new ForbiddenHttpException('You have already been used promo codes.');
                }
            }

            $identityModel = SocialUser::findOne(['uuid' => $identity['id']]);
            if (empty($identityModel)) {
                $identityModel = new SocialUser();
                $identityModel->uuid = ArrayHelper::getValue($identity, 'id');
                $identityModel->name = ArrayHelper::getValue($identity, 'name');
                $identityModel->photo = ArrayHelper::getValue($identity, 'photo');
                $identityModel->gender = ArrayHelper::getValue($identity, 'gender');
                $identityModel->profile_url = ArrayHelper::getValue($identity, 'profileUrl');
                $identityModel->type = ArrayHelper::getValue($identity, 'type', SocialUserType::FACEBOOK);

                if (!$identityModel->save()) {
                    return $identityModel;
                }
            }
            $model->identity_id = $identityModel->uuid;
        }

        if (!$model->save() && !$model->hasErrors()) {
            throw new ErrorException('Failed to create promo code for unknown reason.');
        }

        return $model;
    }

    /**
     * Verifies promo code
     *
     * @param $id
     * @return PromoCode
     * @throws NotFoundHttpException
     */
    public function actionVerify($id)
    {
        $promoCode = PromoCode::findOne([
            'code' => $id,
            'status' => PromoCodeStatus::NEW,
        ]);

        if (!empty($promoCode) && $promoCode->expires_at > Carbon::now()->toDateTimeString()) {
            return $promoCode;
        } else {
            throw new NotFoundHttpException('Invalid promo code.');
        }
    }

}