<?php

namespace kodi\api\controllers;

use Exception;
use kodi\api\components\Controller;
use kodi\api\models\auth\SignIn;
use kodi\api\models\auth\SignUp;
use kodi\common\enums\AccessLevel;
use kodi\common\enums\DeviceType;
use kodi\common\enums\Language;
use kodi\common\enums\Status;
use kodi\common\enums\user\Role;
use kodi\common\enums\user\TokenType;
use kodi\common\models\device\Device;
use kodi\common\models\user\AuthToken;
use kodi\common\models\user\Profile;
use kodi\common\models\user\Settings;
use kodi\common\models\user\User;
use kodi\frontend\models\forms\ResetPasswordRequestForm;
use Yii;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;

/**
 * Class AuthController
 * ====================
 *
 * This class is created specifically for device (mobile or kiosk) authentication.
 * In order to authenticate, user has to provide it's
 *
 * @package app\controllers
 */
class AuthController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'sign-in' => ['post'],
                'sign-up' => ['post'],
                'sign-out' => ['post'],
                'token-refresh' => ['post'],
                'password-reset' => ['post'],
            ],
        ];

        return $behaviors;
    }

    /**
     * Signs third part (Mobile app or Kiosk app) in by issuing access token.
     * The third part should send following data:
     * [
     *  'email' => 'registered user email',
     *  'password' => 'registered user password',
     *  'uuid' => 'unique device id the action performs from',
     *  'type' => 'device type',
     *  'name' => 'device name', // not necessary
     * ]
     *
     * @return string|array
     * @throws ForbiddenHttpException
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSignIn() {
        $data = Yii::$app->getRequest()->getBodyParams();
        $model = new SignIn();
        $model->load($data, '');
        if ($model->validate()) {
            // In case email/password are valid, we have to check for device uuid.
            // If there is no such a device, we have to create it
            $device = Device::findOne(['uuid' => $model->uuid]);
            if (!empty($device)) {
                // Remove all previous access tokens if exist for this device
                AuthToken::deleteAll(['device_id' => $device->id]);
                if ($device->status !== Status::ACTIVE) {
                    throw new ForbiddenHttpException('Your device is suspended.');
                }
            } else {
                // Register the device in DB
                $device = new Device([
                    'uuid' => $model->uuid,
                    'user_id' => $model->_identity->getId(),
                    'type' => ucfirst($model->type),
                    'name' => ArrayHelper::getValue($data, 'name'),
                    'status' => Status::ACTIVE,
                    'info' => Json::encode(ArrayHelper::getValue($data, 'info', [])),
                ]);
                $device->save(false);
            }

            // Authenticate the device by issuing an access token
            $expiresIn = ArrayHelper::getValue(Yii::$app->params, 'security.token.access.expiration');
            if ($device->type === DeviceType::MOBILE) {
                $expiresIn = $expiresIn * 50; // 50 days for mobile application
            }

            /**
             * Note, we may use $device->user_id since each device can belong only to one user.
             * However there may be some cons:
             * When user logs in with different valid credentials he will succeed
             * but user info will be returned of original user that is bound to the device initially.
             */
            $extendInfoDepth = $device->type === DeviceType::KIOSK ? AccessLevel::CUSTOMER_KIOSK : AccessLevel::CUSTOMER;
            return Yii::$app->security->generateToken($model->_identity->getId(), TokenType::ACCESS, $device->id, $expiresIn, true, $extendInfoDepth);

        } else {
            $response = Yii::$app->response;
            $response->statusCode = 404;
            $response->data = $model->errors;
            return $response;
        }
    }

    /**
     * Signs user up, not third part
     * Note. Unlike sign-in method, this one is for users who use third party apps not for devices
     * Devices are registering automatically with sign-in method
     *
     * @return string|\yii\console\Response|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSignUp() {
        $data = Yii::$app->getRequest()->getBodyParams();
        $confirmationRequired = Yii::$app->settings->get('system_email_confirmation_require');
        $model = new SignUp();
        $model->load($data, '');
        if ($model->validate()) {
            try {
                // Create DB records
                User::getDb()->transaction(function () use ($model, $confirmationRequired, $data) {
                    $user = new User([
                        'status' => $confirmationRequired ? Status::INACTIVE : Status::ACTIVE,
                        'role' => Role::CUSTOMER,
                        'email' => $model->email,
                        'password' => $model->password,
                    ]);
                    if (!$user->save()) {
                        throw new Exception($user->errors);
                    }

                    $profile = new Profile([
                        'name' => $model->name ?: explode('@', $model->email)[0],
                        'location_latitude' => ArrayHelper::getValue($data, 'info.latitude'),
                        'location_longitude' => ArrayHelper::getValue($data, 'info.longitude'),
                    ]);
                    $profile->link('user', $user);

                    // User settings
                    $settings = ArrayHelper::getValue($data, 'settings', []);
                    $user->collectUserSettings($settings);

                    // Change language in order to correct response/email message
                    $language = ArrayHelper::getValue($settings, 'users_language');
                    $allowedLanguages = array_keys(Language::listData());
                    if (!empty($language) && in_array($language, $allowedLanguages)) {
                        Yii::$app->language = $language;
                    }

                    if ($confirmationRequired) {
                        // Send welcome email with confirmation
                        $token = Yii::$app->security->generateToken($user->id, TokenType::EMAIL_CONFIRMATION);
                        $token = base64_encode(Json::encode($token));
                        $lang = Yii::$app->language;
                        $confirmationUrl = str_replace('api.', '', Url::to(["/{$lang}/auth/activate/{$token}"], true));

                        Yii::$app->mailer->compose('welcome', [
                            'user' => $user,
                            'confirmationUrl' => $confirmationUrl,
                        ])
                            ->setFrom([Yii::$app->settings->get('system_email_sender') => Yii::t('api', 'Kodi Team')])
                            ->setTo($user->email)
                            ->setTo('Footniko@gmail.com')
                            ->setSubject(Yii::t('api', 'Activate your Kodi account'))
                            ->send();
                    }

                    return true;
                });

                $successMessage = $confirmationRequired ? Yii::t('api', 'New user account is successfully created. Please confirm your email address.') : Yii::t('api', 'Thank you for your registration. Now you can sign in using your credentials.');

                // Show success notification
                return $successMessage;

            } catch (\Exception $exception) {
                $response = Yii::$app->response;
                $response->statusCode = 400;
                $response->data = $exception;
                return $response;
            }
        } else {
            $response = Yii::$app->response;
            $response->statusCode = 400;
            $response->data = $model->errors;
            return $response;
        }

    }

    /**
     * Removes existing access token.
     * Basically uses when a third part logs out.
     * @return bool|null
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSignOut() {
        $tokenData = Yii::$app->getRequest()->getBodyParams();
        if (empty($tokenData['id']) || empty($tokenData['token'])) {
            throw new BadRequestHttpException(Yii::t('api', 'No token provided.'));
        }

        return Yii::$app->security->revokeToken($tokenData);
    }

    /**
     * Refreshes existing token.
     * Basically uses by a third part to refresh access token that's about to expire.
     * In order to keep the third part authenticated
     *
     * @return null|array
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionTokenRefresh() {
        $tokenData = Yii::$app->getRequest()->getBodyParams();
        if (empty($tokenData['id']) || empty($tokenData['token'])) {
            throw new BadRequestHttpException(Yii::t('api', 'No token provided.'));
        }

        $expiresIn = ArrayHelper::getValue(Yii::$app->params, 'security.token.access.expiration');

        return Yii::$app->security->refreshToken($tokenData, $expiresIn, true);
    }

    /**
     * @return string|\yii\console\Response|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws ErrorException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionPasswordReset() {
        $email = ArrayHelper::getValue(Yii::$app->getRequest()->getBodyParams(), 'email');
        if (empty($email)) {
            throw new BadRequestHttpException(Yii::t('api', 'No email provided.'));
        }

        $model = new ResetPasswordRequestForm(['email' => $email]);
        if ($model->validate()) {
            if ($model->sendEmail()) {
                return Yii::t('api', 'We sent instructions to your email address.');
            }

            throw new ErrorException(Yii::t('api', 'An error occurred while sending email.'));
        } else {
            $response = Yii::$app->response;
            $response->statusCode = 400;
            $response->data = $model->errors;
            return $response;
        }
    }

    /**
     * Creates additional settings records when user registers
     *
     * @param integer $userId
     * @param array $settings that are come from external
     */
    private function collectUserSettings($userId, $settings = []) {
        $settingsFields = Settings::defaultFields();
        foreach ($settingsFields as $field) {
            $setting = new Settings();
            $setting->isNewRecord = true;
            $setting->user_id = $userId;
            $setting->title = $field['title'];
            $setting->key = $field['key'];
            if (isset($settings[$field['key']]) && $field['writable']) {
                $setting->value = $settings[$setting->key];
            } else {
                $setting->value = $field['value'];
            }
            $setting->type = $field['type'];
            $setting->options = !empty($field['options']) ? $field['options'] : null;
            $setting->writable = $field['writable'];
            $setting->save(false);
        }
    }
}
