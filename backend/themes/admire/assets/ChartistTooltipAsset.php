<?php

namespace kodi\backend\themes\admire\assets;

use yii\web\AssetBundle;

/**
 * Class "ChartistTooltipAsset"
 * ============================
 *
 * This class represents an additional asset bundle.
 */
class ChartistTooltipAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $baseUrl = '@web/themes/admire';

    /**
     * @inheritdoc
     */
    public $depends = [
        ChartistAsset::class,
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->js = [
            "js/plugins/chartist-tooltip.js"
        ];
    }
}