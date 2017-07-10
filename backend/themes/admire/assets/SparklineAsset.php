<?php

namespace kodi\backend\themes\admire\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class "SparklineAsset"
 * ======================
 *
 * This class represents an additional asset bundle.
 */
class SparklineAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/jquery-sparkline/dist';

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
            "jquery.sparkline{$suffix}.js",
        ];
    }
}