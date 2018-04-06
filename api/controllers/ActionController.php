<?php
namespace kodi\api\controllers;

use app\components\auth\KodiAuth;
use kodi\api\components\Controller;
use kodi\common\enums\action\Status;
use kodi\common\enums\action\Type;
use kodi\common\enums\order\OrderType;
use kodi\common\enums\order\PaymentType;
use kodi\common\enums\order\Status as PaymentStatus;
use kodi\common\enums\PromoCodeStatus;
use kodi\common\models\Action;
use kodi\common\models\Order;
use kodi\common\models\PromoCode;
use kodi\common\models\user\User;
use Yii;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;

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
            'class' => KodiAuth::class,
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'register' => ['post'],
            ],
        ];

        return $behaviors;
    }

    /**
     * Registers new action
     * @return Action
     * @throws ForbiddenHttpException
     */
    public function actionRegister()
    {
        /* @var $user User */
        $user = Yii::$app->user->identity;
        $model = new Action();
        $params = Yii::$app->getRequest()->getBodyParams();
        $details = $params['data'];
        if (!empty($params['data'])) {
            $params['data'] = Json::encode($params['data']);
        }
        $model->load($params, '');
        $model->user_id = $user->getId();
        $model->status = ArrayHelper::getValue($params, 'status', Status::NEW);
        if ($user->device) {
            $model->device_id = $user->device->id;
            $model->device_type = $user->device->type;
        }

        if ($model->action_type === Type::PRINT_SHIPMENT) {
            // Limit free shipment to allowed per a user
            $printsLimit = $user->getSetting('users_max_prints_amount', 1);
            $prints = Action::find()->where([
                'action_type' => Type::PRINT_SHIPMENT,
                'user_id' => $model->user_id,
            ])
                ->andWhere(['>=', 'created_at', new Expression('NOW() - INTERVAL 1 MONTH')])
                ->count();
            if ($prints >= $printsLimit) {
                throw new ForbiddenHttpException(Yii::t('api', 'You have already been used maximum free prints this month.'));
            }
        }

        if ($model->save()) {
            if ($code = ArrayHelper::getValue($params, 'promo_code')) {
                // Update promo code in case the action was related with promo code
                $promoCode = PromoCode::findOne(['code' => $code]);
                if (!empty($promoCode) && $promoCode->status !== PromoCodeStatus::USED) {
                    $promoCode->status = PromoCodeStatus::USED;
                    $promoCode->save(false);
                }
            }

            // If photos to be printed, need to consider it as an order
            if ($model->action_type === Type::PRINT_SHIPMENT) {
                $order = new Order([
                    'type' => OrderType::PHOTO,
                    'user_id' => $model->user_id,
                    'name' => ArrayHelper::getValue($details, 'shipping.name'),
                    'surname' => ArrayHelper::getValue($details, 'shipping.surname'),
                    'email' => $user->email,
                    'country' => ArrayHelper::getValue($details, 'shipping.country'),
                    'city' => ArrayHelper::getValue($details, 'shipping.city'),
                    'state' => ArrayHelper::getValue($details, 'shipping.state'),
                    'address' => ArrayHelper::getValue($details, 'shipping.address'),
                    'postcode' => ArrayHelper::getValue($details, 'shipping.postcode'),
                    'location_latitude' => ArrayHelper::getValue($details, 'location.latitude'),
                    'location_longitude' => ArrayHelper::getValue($details, 'location.longitude'),
                    'color' => 'yellow',
                    'quantity' => 1,
                    'payment_type' => PaymentType::NONE,
                    'order_data' => Json::encode(['action_id' => $model->id]),
                    'status' => PaymentStatus::PENDING,
                ]);
                $order->save();
            }
        }

        return $model;
    }

}