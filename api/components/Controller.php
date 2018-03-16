<?php

namespace kodi\api\components;

use kodi\common\enums\Language;
use kodi\common\models\user\User;
use Yii;

/**
 * Class Controller
 * ================
 *
 * @package kodi\api\components
 */
class Controller extends \yii\rest\Controller
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $language = Yii::$app->request->getHeaders()->get('Content-Language');
        $allowedLanguages = array_keys(Language::listData());
        if (!empty($language) && in_array($language, $allowedLanguages)) {
            Yii::$app->language = $language;
        } else {
            if (!Yii::$app->user->isGuest) {
                /* @var $user User */
                $user = Yii::$app->user->identity;
                $language = $user->getSetting('users_language', Yii::$app->language);
                Yii::$app->language = $language;
            }
        }

        return parent::beforeAction($action);
    }
}