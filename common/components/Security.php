<?

namespace kodi\common\components;

use Carbon\Carbon;
use kodi\common\enums\user\TokenType;
use kodi\common\models\user\AuthToken;
use Yii;
use yii\helpers\ArrayHelper;
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
     * @param int $expiresIn 1 day by default
     * @param bool $genRefreshToken
     * @return null|array
     */
    public function generateToken($userId, $type = TokenType::EMAIL_CONFIRMATION, $deviceId = null, $expiresIn = 86400, $genRefreshToken = false)
    {
        $token = $this->generateRandomString();
        $tokenRefresh = $this->generateRandomString();
        $model = new AuthToken([
            'user_id' => $userId ?: Yii::$app->user->id,
            'device_id' => $deviceId ?: null,
            'type' => $type,
            'token' => $this->maskToken($token), // store encrypted tokens in DB
            'token_refresh' => $genRefreshToken ? $this->maskToken($tokenRefresh) : null,
            'expires_at' => Carbon::now()->addSeconds($expiresIn)->toDateTimeString(),
        ]);
        if ($model->save()) {
            return [
                'user' => $model->user->profile,
                'session' => [
                    'id' => $model->id,
                    'token' => $token,
                    'token_refresh' => $tokenRefresh,
                    'expires_in' => $expiresIn,
                ],
            ];
        }

        return null;
    }

    /**
     * Finds record by given token and expiration date
     *
     * @param $tokenData
     * @return array|AuthToken|null
     * @throws NotFoundHttpException
     */
    public function findToken($tokenData)
    {
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
     * @param $tokenData
     * @param int $expiresIn 1 day by default
     * @return array|null New token data
     * @throws NotFoundHttpException
     */
    public function refreshToken($tokenData, $expiresIn = 86400)
    {
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
            $authToken->expires_at = Carbon::now()->addSeconds($expiresIn)->toDateTimeString();

            if ($authToken->save(false)) {
                return [
                    'user' => $authToken->user->profile,
                    'session' => [
                        'id' => $authToken->id,
                        'token' => $token,
                        'token_refresh' => $tokenRefresh,
                        'expires_in' => $expiresIn,
                    ],
                ];
            }
        }

        throw new NotFoundHttpException('Invalid refresh token.');
    }

    /**
     * Removes current token
     *
     * @param $tokenData
     * @return bool
     * @throws NotFoundHttpException
     */
    public function revokeToken($tokenData)
    {
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