<?php

namespace kodi\api\controllers;

use kodi\common\enums\setting\Bunch;
use kodi\common\models\device\Device;
use kodi\common\models\Setting;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Yii;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;

/**
 * Class AuthController
 *
 * @package app\controllers
 */
class AuthController extends Controller
{
    /**
     * Generates JWT token
     *
     * @param $id
     * @return mixed
     * @throws ErrorException
     */
    public function actionIndex($id) {
        $device = Device::findIdentityByAccessToken($id);
        if (empty($device)) {
            throw new ErrorException('Invalid token');
        }

        $signer = new Sha256();
        $secret = ArrayHelper::getValue(Yii::$app->params, 'security.jwt.secret');
        $expiration = ArrayHelper::getValue(Yii::$app->params, 'security.jwt.expiration');
        $expiresAt = time() + $expiration;
        $token = (new Builder())->setExpiration($expiresAt)->sign($signer, $secret)->getToken();
        $settingsData = Setting::find()->all();
        $settings = [];
        $allowedBunches = [Bunch::COMPONENTS, Bunch::DEVICES];
        foreach ($settingsData as $setting) {
            // Set only allowed settings
            if (in_array($setting->bunch, $allowedBunches)) {
                $settings += [$setting->name => $setting->value];
            }
        }

        return [
            'token' => [
                'value' => (string)$token,
                'expiresAt' => $expiresAt,
                'deviceId' => $device->id,
            ],
            'settings' => $settings,
        ];
    }
}
