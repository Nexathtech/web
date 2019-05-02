<?php

namespace kodi\api\controllers;

use app\components\auth\KodiAuth;
use Carbon\Carbon;
use kodi\api\components\Controller;
use kodi\common\enums\AccessLevel;
use kodi\common\enums\Language;
use kodi\common\enums\order\OrderType;
use kodi\common\enums\Status;
use kodi\common\models\Action;
use kodi\common\models\event\Event;
use kodi\common\models\Order;
use kodi\common\models\Setting;
use sammaye\mailchimp\exceptions\MailChimpException;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => KodiAuth::class,
            'only' => ['events'],
            'optional' => ['events']
        ];

        return $behaviors;
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return Yii::t('api', 'It works!');
    }

    /**
     * Returns system settings.
     * Every setting has its access level. For guests there will be no sensible settings
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionSettings()
    {
        $query = Setting::find()->select(['name', 'value']);
        if ($bunch = Yii::$app->request->get('bunch')) {
            $query->where(['bunch' => $bunch]);
        }
        if ($key = Yii::$app->request->get('key')) {
            $query->andWhere(['name' => $key]);
        }

        $accessLevel = AccessLevel::EVERYONE;
        if (!Yii::$app->user->isGuest) {
            $accessLevel = AccessLevel::CUSTOMER;
        }
        $settings = $query->andWhere(['<=', 'access_level', $accessLevel])->asArray()->all();

        foreach ($settings as $i => $setting) {
            if ($setting['name'] === 'mobile_app_orders_allowed') {
                if ($setting['value'] > 0) {
                    $settings[$i]['value'] = true;
                    // check amount of current PrintShipment orders
                    $pOrders = Order::find()->where(['type' => OrderType::PHOTO])->count();
                    if ($pOrders >= $setting['value']) {
                        $settings[$i]['value'] = false;
                    }
                } else {
                    $settings[$i]['value'] = true;
                }
            }

            if ($setting['name'] === 'device_countries_support') {
                $settings[$i]['value'] = explode(',', $setting['value']);
            }
        }

        $settings = ArrayHelper::map($settings, 'name', 'value');
        // Additional data
        $settings['languages_support'] = Language::listData();

        return $settings;
    }

    /**
     * Adds obtained email to MailChimp list
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function actionWaitingList()
    {
        $data = Yii::$app->getRequest()->getBodyParams();
        $message = Yii::t('api', 'Wasn\'t able to add the email to the waiting list.');
        $response = Yii::$app->response;
        $response->statusCode = 500;

        if ($email = ArrayHelper::getValue($data, 'email')) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $listId = 'baa1279fda';
                $params = [
                    'email_address' => $email,
                    'status' => 'subscribed',
                    'language' => Yii::$app->language,
                ];
                try {
                    Yii::$app->mailchimp->post("/lists/{$listId}/members", $params);
                    $response->statusCode = 201;
                    $message = Yii::t('api', 'Thank you! The email {email} was successfully added to the Waiting list.', ['email' => $email]);
                } catch (MailChimpException $exception) {
                    $message = explode('.', $exception->getMessage());
                    $message = $message[0];
                    $response->statusCode = 400;
                }
            } else {
                $message = Yii::t('api', 'Invalid email address');
            }
        }

        $response->data = ['message' => $message];
        return $response;
    }

    /**
     * Returns near events based on user's location
     *
     * @param $latitude
     * @param $longitude
     * @return array|Event[]|Setting[]|\yii\db\ActiveRecord[]
     */
    public function actionEvents($latitude, $longitude)
    {
        $userId = Yii::$app->getUser()->id;
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $events = Event::find()
            ->select("id, title, logo, location_latitude, location_longitude, location_radius, starts_at, ends_at, users_max_prints_amount, (6371000 * acos(cos(radians({$latitude})) * cos(radians(location_latitude)) * cos(radians(location_longitude) - radians({$longitude})) + sin(radians({$latitude})) * sin(radians(location_latitude))) - location_radius) AS distance")
            ->where(['status' => Status::ACTIVE])
            ->andWhere(['<', 'starts_at', $now])
            ->andWhere(['>', 'ends_at', $now])
            ->having(['<', 'distance', 0])
            ->orderBy(['distance' => SORT_ASC])
            ->asArray()
            ->all();

        if ($userId) {
            $printsAmount = 0;
            foreach ($events as $key => $event) {
                $prints = Action::getUserRecentPrints($userId, 1, $event['id']);

                foreach ($prints as $print) {
                    /* @var $print Action */
                    $printData = Json::decode($print->data);
                    if (!empty($printData['images'])) {
                        foreach ($printData['images'] as $image) {
                            $printsAmount += $image['count'];
                        }
                    }
                }

                $printsRemain = $event['users_max_prints_amount'] - $printsAmount;
                $events[$key]['users_max_prints_amount'] = $printsRemain;
                $events[$key]['user_id'] = $userId;
            }
        }

        return $events;
    }
}
