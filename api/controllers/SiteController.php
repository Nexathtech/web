<?php

namespace kodi\api\controllers;

use kodi\api\components\Controller;
use kodi\common\enums\AccessLevel;
use kodi\common\enums\Language;
use kodi\common\enums\order\OrderType;
use kodi\common\models\Order;
use kodi\common\models\Setting;
use kodi\common\models\user\User;
use sammaye\mailchimp\exceptions\MailChimpException;
use Yii;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;

class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = User::findOne(['email' => 'Footniko@gmail.com']);
        $confirmationUrl = 'https://meetkodi.com';
        Yii::$app->mailer->compose('welcome', [
            'user' => $user,
            'confirmationUrl' => $confirmationUrl,
        ])
            ->setFrom([Yii::$app->settings->get('system_email_sender') => Yii::t('api', 'Kodi Team')])
            ->setTo('web-nn12p@mail-tester.com')
            ->setSubject(Yii::t('api', 'Welcome on Kodiplus!'))
            ->send();

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
     * @throws ErrorException
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
}
