<?php

use M1\Env\Parser;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

/**
 * Parses application environment variables.
 */

// Determine paths to the environment files
$envPath = dirname(dirname(__DIR__));
$localEnvPath = getenv('KODI_COMMON_LOCAL_ENV_PATH')
    ? FileHelper::normalizePath($envPath . '/' . getenv('KODI_COMMON_LOCAL_ENV_PATH'))
    : $envPath;

// Parse environment variables
$localEnv = [];
$defaultEnv = Parser::parse(file_get_contents("{$envPath}/.env.default"));
if (is_readable("{$localEnvPath}/.env")) {
    $localEnv = Parser::parse(file_get_contents("{$localEnvPath}/.env"));
}
$fullEnv = ArrayHelper::merge($defaultEnv, $localEnv);

// Apply parsed values
foreach ($fullEnv as $key => $value) {
    if (getenv($key) === false) {
        putenv("{$key}={$value}");
        $_ENV[$key] = $value;
    }
}
foreach ($_SERVER as $key => $value) {
    if (strpos($key, 'KODI_') === 0) {
        $_ENV[$key] = $value;
    }
}

// Override Yii env variables
defined('YII_DEBUG') or define('YII_DEBUG', filter_var(getenv('KODI_COMMON_DEBUG'), FILTER_VALIDATE_BOOLEAN));
defined('YII_ENV') or define('YII_ENV', getenv('KODI_COMMON_ENVIRONMENT'));
defined('YII_ENV_LOCAL') or define('YII_ENV_LOCAL', strpos(YII_ENV, 'local_') === 0);
defined('YII_ENV_DEV') or define('YII_ENV_DEV', YII_ENV === 'development');
defined('YII_ENV_STAGING') or define('YII_ENV_STAGING', YII_ENV === 'staging');
defined('YII_ENV_PROD') or define('YII_ENV_PROD', YII_ENV === 'production');
defined('YII_ENV_TEST') or define('YII_ENV_TEST', YII_ENV === 'test');