<?php

namespace kodi\api\controllers;

use kodi\common\enums\order\OrderType;
use kodi\common\enums\setting\Bunch;
use kodi\common\models\Order;
use kodi\common\models\Setting;
use sammaye\mailchimp\exceptions\MailChimpException;
use Yii;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;

class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return Yii::t('app', 'It works!');
    }

    /**
     * Returns configured settings for mobile app
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionMobileSettings()
    {
        $settings = Setting::find()->select(['name', 'value'])->where(['bunch' => Bunch::MOBILE_APP])->asArray()->all();

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
        }

        return $settings;
    }

    /**
     * Adds obtained email to MailChimp list
     *
     * @return array
     * @throws ErrorException
     */
    public function actionWaitingList()
    {
        $data = Yii::$app->getRequest()->getBodyParams();
        $message = 'Wasn\'t able to add the email to the waiting list.';

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
                    return $data;
                } catch (MailChimpException $exception) {
                    $message = explode('.', $exception->getMessage());
                    $message = $message[0];
                }
            } else {
                $message = 'Invalid email address';
            }
        }

        return $message;
        throw new ErrorException($message);
    }
}
