<?php

namespace kodi\backend\themes\admire\assets;

use kodi\backend\assets\AppAsset;
use yii\web\AssetBundle;

/**
 * Class "ThemeAsset"
 * ==================
 *
 * This class represents an additional asset bundle.
 */
class ThemeAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot/themes/admire';

    /**
     * @inheritdoc
     */
    public $baseUrl = '@web/themes/admire';

    /**
     * @inheritdoc
     */
    public $depends = [
        AppAsset::class,
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->js = [
            "js/components.js",
            "js/custom.js",
        ];

        $this->css = [
            "css/components.css",
            "css/custom.css",
            "css/black_skin.css",
            "css/dataTables.bootstrap.css",
            "css/tables.css",
            "css/icon.css",
            "css/style.css",
        ];
    }
}