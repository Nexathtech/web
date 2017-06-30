<?php

namespace app\components\auth;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Yii;
use yii\filters\auth\AuthMethod;
use yii\helpers\ArrayHelper;

/**
 * Class JwtAuth
 *
 * JwtAuth is an action filter that supports the Json Web Token authentication method.
 */
class JwtAuth extends AuthMethod
{
    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get('Authorization');
        if ($authHeader !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $token = (new Parser())->parse((string) $matches[1]); // Parses from a string
            $signer = new Sha256();
            $secret = ArrayHelper::getValue(Yii::$app->params, 'security.jwt.secret');

            if ($token->verify($signer, $secret) && !$token->isExpired()) {
                return true;
            }
        }

        return null;
    }
}
