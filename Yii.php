<?php

/**
 * Yii app stub file. Autogenerated by yii2-stubs-generator (stubs console command).
 * Used for enhanced IDE code autocompletion.
 * Updated on 2016-11-11T16:42:38+0000
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication|WebApplication|ConsoleApplication the application instance
     */
    public static $app;
}
/**
 * @property yii\db\Connection $db
 * @property kodi\common\models\Setting $settings
 * @property kodi\common\components\Security $security
 * @property yii\i18n\I18N $i18n
 * @property yii\log\Dispatcher $log
 * @property yii\web\Request $request
 * @property yii\web\UrlManager $urlManager
 * @property yii\web\AssetManager $assetManager
 * @property yii\web\View $view
 * @property yii\web\ErrorHandler $errorHandler
 **/
abstract class BaseApplication extends yii\base\Application
{
}

/**
 * @property yii\db\Connection $db
 * @property kodi\common\models\Setting $settings
 * @property kodi\common\components\Security $security
 * @property yii\i18n\I18N $i18n
 * @property yii\log\Dispatcher $log
 * @property yii\web\Request $request
 * @property yii\web\UrlManager $urlManager
 * @property yii\web\AssetManager $assetManager
 * @property yii\web\View $view
 * @property yii\web\ErrorHandler $errorHandler
 **/
class WebApplication extends yii\web\Application
{
}

/**
 * @property yii\db\Connection $db
 * @property kodi\common\models\Setting $settings
 * @property kodi\common\components\Security $security
 * @property yii\i18n\I18N $i18n
 * @property yii\log\Dispatcher $log
 * @property yii\web\Request $request
 * @property yii\web\UrlManager $urlManager
 * @property yii\web\AssetManager $assetManager
 * @property yii\web\View $view
 * @property yii\web\ErrorHandler $errorHandler
 **/
class ConsoleApplication extends yii\console\Application
{
}