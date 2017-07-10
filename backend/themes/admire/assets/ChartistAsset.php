<?php

namespace kodi\backend\themes\admire\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class "ChartistAsset"
 * =====================
 *
 * This class represents an additional asset bundle.
 */
class ChartistAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/chartist/dist';

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
            "chartist{$suffix}.js"
        ];
        $this->css = [
            "chartist{$suffix}.css"
        ];
    }
}