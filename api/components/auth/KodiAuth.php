<?php

namespace app\components\auth;

use kodi\common\models\user\User;
use Yii;
use yii\filters\auth\AuthMethod;
use yii\helpers\Json;

/**
 * Class JwtAuth
 *
 * KodiAuth is an action filter that supports custom authentication method.
 */
class KodiAuth extends AuthMethod
{
    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get('Authorization');
        if ($authHeader !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $tokenData = Json::decode(base64_decode((string)$matches[1]));
            $identity = User::findIdentityByAccessToken($tokenData, null, true);
            if (!empty($identity)) {
                $user->switchIdentity($identity);
                return $identity;
            }
        }

        return null;
    }
}
