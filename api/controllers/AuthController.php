<?php

namespace kodi\api\controllers;

use kodi\common\models\device\Device;
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
        return [
            'token' => (string)$token,
            'expiresAt' => $expiresAt,
            'deviceId' => $device->id,
        ];
    }
}
