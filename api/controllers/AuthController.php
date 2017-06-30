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
        if (empty(Device::findIdentityByAccessToken($id))) {
            throw new ErrorException('Invalid token');
        }

        $signer = new Sha256();
        $secret = ArrayHelper::getValue(Yii::$app->params, 'security.jwt.secret');
        $expiration = ArrayHelper::getValue(Yii::$app->params, 'security.jwt.expiration');
        $token = (new Builder())->setExpiration(time() + $expiration)->sign($signer, $secret)->getToken();
        return (string)$token;
    }
}
