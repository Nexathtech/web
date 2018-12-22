<?php
namespace kodi\api\controllers;

use app\components\auth\KodiAuth;
use kodi\api\components\Controller;
use kodi\common\enums\promocode\Status as PromoCodeStatus;
use kodi\common\enums\SocialUserType;
use kodi\common\models\promocode\PromoCode;
use kodi\common\models\SocialUser;
use Yii;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
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
            'class' => KodiAuth::class,
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'create' => ['get', 'post'],
            ],
        ];

        return $behaviors;
    }

    /**
     * Creates promo code and social user if needed
     * Uses when we create a promo code from the KIOSK APP and send it to the user's social account
     *
     * @return PromoCode|SocialUser
     * @throws ErrorException
     * @throws ForbiddenHttpException
     * @throws \yii\base\InvalidConfigException
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
                    throw new ForbiddenHttpException(Yii::t('api', 'You have already been used promo codes.'));
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
            throw new ErrorException(Yii::t('api', 'Failed to create promo code for unknown reason.'));
        }

        return $model;
    }

    /**
     * Verifies und uses specified promo code
     *
     * @param $id
     * @return PromoCode
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionUse($id)
    {
        $promoCode = PromoCode::findOne(['code' => $id]);

        if (!empty($promoCode) && $promoCode->isValid()) {
            $promoCode->use();
            return $promoCode;
        } else {
            throw new NotFoundHttpException(Yii::t('api', 'Invalid promo code.'));
        }
    }

}
