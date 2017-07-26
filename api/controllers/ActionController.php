<?php
namespace kodi\api\controllers;

use app\components\auth\JwtAuth;
use kodi\common\enums\PromoCodeStatus;
use kodi\common\models\Action;
use kodi\common\models\PromoCode;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\rest\Controller;

/**
 * Class ActionController
 * ======================
 *
 * @package kodi\api\controllers
 */
class ActionController extends Controller
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
                'register' => ['post'],
            ],
        ];

        return $behaviors;
    }

    /**
     * Registers new action
     *
     * @return Action
     */
    public function actionRegister()
    {
        $model = new Action();
        $params = Yii::$app->getRequest()->getBodyParams();
        if (!empty($params['data'])) {
            $params['data'] = Json::encode($params['data']);
        }
        $model->load($params, '');

        if ($model->save()) {
            if ($code = ArrayHelper::getValue($params, 'promo_code')) {
                // Update promo code in case the action was related with promo code
                $promoCode = PromoCode::findOne(['code' => $code]);
                if (!empty($promoCode) && $promoCode->status !== PromoCodeStatus::USED) {
                    $promoCode->status = PromoCodeStatus::USED;
                    $promoCode->save(false);
                }
            }
        }

        return $model;
    }

}