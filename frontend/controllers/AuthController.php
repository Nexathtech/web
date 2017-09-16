<?php

namespace kodi\frontend\controllers;

use kodi\common\enums\AlertType;
use kodi\common\enums\user\Status;
use kodi\common\models\user\User;
use Yii;
use yii\web\Controller;

/**
 * Class `AuthController`
 * ======================
 *
 * This controller is responsible for user authentication.
 */
final class AuthController extends Controller
{
    /**
     * Activates user's account after manual registration
     *
     * @param $token
     * @return \yii\web\Response
     */
    public function actionActivate($token)
    {
        $authToken = Yii::$app->security->findToken($token);
        if ($authToken) {
            $user = User::findOne(['id' => $authToken->user_id]);
            if ($user) {
                $user->status = Status::ACTIVE;
                $user->save(false);
                $authToken->delete();
                Yii::$app->session->addFlash(AlertType::SUCCESS, [
                    'message' => Yii::t('frontend', 'Your account was successfully activated! You can now login using your credentials.')
                ]);
            }
        } else {
            Yii::$app->session->addFlash(AlertType::ERROR, [
                'message' => Yii::t('frontend', 'An error occurred while trying to activate your account.')
            ]);
        }

        return $this->goHome();
    }
}
