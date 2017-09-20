<?

namespace kodi\common\components;

use Carbon\Carbon;
use kodi\common\enums\user\TokenType;
use kodi\common\models\user\AuthToken;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

/**
 * Class `Security`
 * ================
 *
 * This is a helper class unique user tokens handling.
 */
class Security extends \yii\base\Security
{
    /**
     * Generates unique token
     *
     * @param int $userId
     * @param string $type
     * @param null $deviceId
     * @param null $expiresAt
     * @param bool $genRefreshToken
     * @return null|string
     */
    public function generateToken($userId, $type = TokenType::EMAIL_CONFIRMATION, $deviceId = null, $expiresAt = null, $genRefreshToken = false)
    {
        $token = $this->generateRandomString();
        $tokenRefresh = $this->generateRandomString();
        $model = new AuthToken([
            'user_id' => $userId ?: Yii::$app->user->id,
            'device_id' => $deviceId ?: null,
            'type' => $type,
            'token' => $this->maskToken($token), // store encrypted tokens in DB
            'token_refresh' => $genRefreshToken ? $this->maskToken($tokenRefresh) : null,
            'expires_at' => $expiresAt ?: Carbon::now()->addDays(1)->toDateTimeString(),
        ]);
        if ($model->save()) {
            return base64_encode(Json::encode([
                'user' => [
                    'id' => $model->user->id,
                    'email' => $model->user->email,
                    'name' => $model->user->profile->name,
                ],
                'session' => [
                    'id' => $model->id,
                    'token' => $token,
                    'token_refresh' => $tokenRefresh,
                    'expires_at' => $model->expires_at,
                ],
            ]));
        }

        return null;
    }

    /**
     * Finds record by given token and expiration date
     *
     * @param $token
     * @return array|AuthToken|null
     * @throws NotFoundHttpException
     */
    public function findToken($token)
    {
        $tokenData = json_decode(base64_decode($token), true);
        if (empty($tokenData) || empty($tokenData['id']) || empty($tokenData['token'])) {
            throw new NotFoundHttpException('The token not found.');
        }

        /** @var $authToken AuthToken */
        $authToken = AuthToken::find()->where('id = :id AND expires_at >= :now', [
            ':id' => $tokenData['id'],
            ':now' => Carbon::now()->toDateTimeString(),
        ])->one();
        
        if ($authToken && ($tokenData['token'] === $this->unmaskToken($authToken->token))) {
            return $authToken;
        }

        throw new NotFoundHttpException('The token not found.');
    }

    /**
     * Refreshes current token by token refresh
     *
     * @param $tokenRefresh
     * @param null $expiresAt
     * @return null|string New token data
     * @throws NotFoundHttpException
     */
    public function refreshToken($tokenRefresh, $expiresAt = null)
    {
        $tokenData = json_decode(base64_decode($tokenRefresh), true);
        if (empty($tokenData) || empty($tokenData['id']) || empty($tokenData['token'])) {
            throw new NotFoundHttpException('Invalid refresh token.');
        }

        /** @var $authToken AuthToken */
        $authToken = AuthToken::findOne(['id' => $tokenData['id']]);

        if ($authToken && ($tokenData['token'] === $this->unmaskToken($authToken->token_refresh))) {
            $tokenExpiresIn = ArrayHelper::getValue(Yii::$app->params, 'security.token.refresh.expiration');
            $tokenExpiresAt = Carbon::createFromFormat('Y-m-d H:i:s', $authToken->expires_at)->addSeconds($tokenExpiresIn);
            if ($tokenExpiresAt < Carbon::now()) {
                throw new NotFoundHttpException('Invalid refresh token.');
            }

            $token = $this->generateRandomString();
            $tokenRefresh = $this->generateRandomString();
            $authToken->token = $this->maskToken($token);
            $authToken->token_refresh = $this->maskToken($tokenRefresh);
            $authToken->created_at = Carbon::now()->toDateTimeString();
            $authToken->expires_at = $expiresAt ?: Carbon::now()->addDays(1)->toDateTimeString();

            if ($authToken->save(false)) {
                return base64_encode(Json::encode([
                    'user' => [
                        'id' => $authToken->user->id,
                        'email' => $authToken->user->email,
                        'name' => $authToken->user->profile->name,
                    ],
                    'session' => [
                        'id' => $authToken->id,
                        'token' => $token,
                        'token_refresh' => $tokenRefresh,
                        'expires_at' => $authToken->expires_at,
                    ],
                ]));
            }
        }

        throw new NotFoundHttpException('Invalid refresh token.');
    }

    /**
     * Removes current token
     *
     * @param $token
     * @return bool
     * @throws NotFoundHttpException
     */
    public function revokeToken($token)
    {
        $tokenData = json_decode(base64_decode($token), true);
        if (empty($tokenData) || empty($tokenData['id']) || empty($tokenData['token'])) {
            throw new NotFoundHttpException('Invalid token.');
        }

        /** @var $authToken AuthToken */
        $authToken = AuthToken::find()->where('id = :id AND expires_at >= :now', [
            ':id' => $tokenData['id'],
            ':now' => Carbon::now()->toDateTimeString(),
        ])->one();

        if ($authToken && ($tokenData['token'] === $this->unmaskToken($authToken->token))) {
            $authToken->delete();

            return true;
        }

        throw new NotFoundHttpException('Invalid token.');
    }
}