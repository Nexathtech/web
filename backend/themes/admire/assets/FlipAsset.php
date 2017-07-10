<?php

namespace kodi\backend\themes\admire\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class "FlipAsset"
 * =================
 *
 * This class represents an additional asset bundle.
 */
class FlipAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/flip/dist';

    /**
     * @inheritdoc
     */
    public $depends = [
        JqueryAsset::class,
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $suffix = YII_DEBUG ? '' : '.min';
        $this->js = [
            "jquery.flip{$suffix}.js",
        ];
    }
}