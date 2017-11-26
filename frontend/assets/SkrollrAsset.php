<?php

namespace kodi\frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class SkrollrAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/plugins/skrollr.stylesheets.min.js', // allows using "data" selectors in css files
        'js/plugins/skrollr.min.js',
    ];
}
