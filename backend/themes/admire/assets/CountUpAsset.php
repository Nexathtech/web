<?php

namespace kodi\backend\themes\admire\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class "CountUpAsset"
 * ====================
 *
 * This class represents an additional asset bundle.
 */
class CountUpAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/countup/dist';

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
            "countUp{$suffix}.js",
        ];
    }
}