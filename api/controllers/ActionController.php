<?php
namespace kodi\api\controllers;

use app\components\auth\KodiAuth;
use kodi\api\components\Controller;
use kodi\common\enums\action\Status;
use kodi\common\enums\action\Type;
use kodi\common\enums\ImageType;
use kodi\common\enums\order\OrderType;
use kodi\common\enums\order\PaymentType;
use kodi\common\enums\order\Status as PaymentStatus;
use kodi\common\models\Action;
use kodi\common\models\AdImage;
use kodi\common\models\event\Event;
use kodi\common\models\Order;
use kodi\common\models\user\Profile;
use kodi\common\models\user\User;
use Yii;
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
     * @return array
     * @throws ForbiddenHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionRegister()
    {
        /* @var $user User */
        $user = Yii::$app->user->identity;
        $model = new Action();
        $order = null;
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
            // Limit free shipment to allowed amount for the user
            $printsLimit = $user->getSetting('users_max_prints_amount', 1);
            $limitInterval = 1; // in months
            $printsAmount = 0;
            // For events we use separate limits
            $eventId = ArrayHelper::getValue($params, 'event_id');
            if ($eventId) {
                $event = Event::findOne(['id' => $eventId]);
                if (!empty($event)) {
                    $printsLimit = $event->users_max_prints_amount;
                }
            }
            $prints = Action::getUserRecentPrints($model->user_id, $limitInterval, $eventId);

            foreach ($prints as $print) {
                /* @var $print Action */
                $printData = Json::decode($print->data);
                if (!empty($printData['images'])) {
                    foreach ($printData['images'] as $image) {
                        $printsAmount += $image['count'];
                    }
                }
            }

            if ($printsAmount >= $printsLimit) {
                throw new ForbiddenHttpException(Yii::t('api', 'You have already been used maximum free prints this month.'));
            }
        }

        if ($model->action_type === Type::ADD_ADVERTISEMENT) {
            // Limit brand's ads to allowed amount per brand
            $adsLimit = $user->getSetting('users_max_prints_amount_brands', 1);
            $adsAmount = Action::getUserRecentPrintsAmount($model->user_id);
            if ($adsAmount >= $adsLimit) {
                throw new ForbiddenHttpException(Yii::t('api', 'You have already been used maximum free advertisement images this month.'));
            }
        }

        if ($model->save()) {
            // Now update profile info if empty
            $this->updateProfile($user->profile, $details);

            // If photos to be printed, need to consider it as an order
            if ($model->action_type === Type::PRINT_SHIPMENT) {
                $profile = $user->profile;
                $orderData = ['action_id' => $model->id];
                if (!empty($params['event_id'])) {
                    $orderData['event_id'] = $params['event_id'];
                }

                $order = new Order([
                    'type' => OrderType::PHOTO,
                    'user_id' => $model->user_id,
                    'name' => ArrayHelper::getValue($details, 'shipping.name', $profile->name),
                    'surname' => ArrayHelper::getValue($details, 'shipping.surname', $profile->surname),
                    'email' => $user->email,
                    'country' => ArrayHelper::getValue($details, 'shipping.country', $profile->country),
                    'city' => ArrayHelper::getValue($details, 'shipping.city', $profile->city),
                    'state' => ArrayHelper::getValue($details, 'shipping.state', $profile->state),
                    'address' => ArrayHelper::getValue($details, 'shipping.address', $profile->address),
                    'postcode' => ArrayHelper::getValue($details, 'shipping.postcode', $profile->postcode),
                    'location_latitude' => ArrayHelper::getValue($details, 'location.latitude', $profile->location_latitude),
                    'location_longitude' => ArrayHelper::getValue($details, 'location.longitude', $profile->location_longitude),
                    'color' => 'yellow',
                    'quantity' => 1,
                    'payment_type' => PaymentType::NONE,
                    'order_data' => Json::encode($orderData),
                    'status' => PaymentStatus::PENDING,
                ]);
                $order->save(false);
            }

            // If it's advertisement photos, need to save them
            if ($model->action_type === Type::ADD_ADVERTISEMENT) {
                foreach ($details['images'] as $image) {
                    $adImage = new AdImage([
                        'user_id' => $model->user_id,
                        'image' => $image['path'],
                        'type' => ImageType::ADVERTISEMENT,
                        'location_latitude' => ArrayHelper::getValue($details, 'location.latitude', $user->profile->location_latitude),
                        'location_longitude' => ArrayHelper::getValue($details, 'location.longitude', $user->profile->location_longitude),
                    ]);
                    $adImage->save(false);
                }
            }
        }

        $data = $model->toArray();
        if ($order) {
            $data['order_id'] = $order->id;
        }

        return $data;
    }

    /**
     * @param Profile $profile
     * @param $details
     */
    private function updateProfile(Profile $profile, $details) {
        $updatedFields = 0;
        if (empty($profile->surname)) {
            $profile->surname = ArrayHelper::getValue($details, 'shipping.surname');
            $updatedFields++;
        }
        if (empty($profile->country)) {
            $profile->country = ArrayHelper::getValue($details, 'shipping.country');
            $updatedFields++;
        }
        if (empty($profile->city)) {
            $profile->city = ArrayHelper::getValue($details, 'shipping.city');
            $updatedFields++;
        }
        if (empty($profile->state)) {
            $profile->state = ArrayHelper::getValue($details, 'shipping.state');
            $updatedFields++;
        }
        if (empty($profile->address)) {
            $profile->address = ArrayHelper::getValue($details, 'shipping.address');
            $updatedFields++;
        }
        if (empty($profile->postcode)) {
            $profile->postcode = ArrayHelper::getValue($details, 'shipping.postcode');
            $updatedFields++;
        }
        if (empty($profile->location_latitude)) {
            $profile->location_latitude = ArrayHelper::getValue($details, 'location.latitude');
            $updatedFields++;
        }
        if (empty($profile->location_longitude)) {
            $profile->location_longitude = ArrayHelper::getValue($details, 'location.longitude');
            $updatedFields++;
        }

        if ($updatedFields > 0) {
            $profile->save(false);
        }
    }

}
